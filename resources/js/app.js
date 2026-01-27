import './bootstrap';
import Alpine from 'alpinejs';

// Configure Laravel Echo only if Pusher credentials are available
if (import.meta.env.VITE_PUSHER_APP_KEY) {
  import('laravel-echo').then(({ default: Echo }) => {
    import('pusher-js').then(({ default: Pusher }) => {
      window.Pusher = Pusher;

      window.Echo = new Echo({
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
        wsHost: import.meta.env.VITE_PUSHER_HOST
          ? import.meta.env.VITE_PUSHER_HOST
          : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher-channels.net`,
        wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
        wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
        forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
        enabledTransports: ['ws', 'wss']
      });
    });
  });
}

// Start Alpine
window.Alpine = Alpine;

// Global Alpine components
Alpine.data('mobileMenu', () => ({
  open: false,
  toggle() {
    this.open = !this.open;
  },
  close() {
    this.open = false;
  }
}));

Alpine.data('modal', () => ({
  open: false,
  show() {
    this.open = true;
    document.body.style.overflow = 'hidden';
  },
  hide() {
    this.open = false;
    document.body.style.overflow = 'auto';
  }
}));

Alpine.data('calendar', () => ({
  currentDate: new Date(),
  selectedDate: null,
  events: [],

  get daysInMonth() {
    const year = this.currentDate.getFullYear();
    const month = this.currentDate.getMonth();
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const daysInMonth = lastDay.getDate();
    const startingDayOfWeek = firstDay.getDay();

    const days = [];

    // Add empty cells for days before the first day of the month
    for (let i = 0; i < startingDayOfWeek; i++) {
      days.push(null);
    }

    // Add days of the month
    for (let day = 1; day <= daysInMonth; day++) {
      days.push(new Date(year, month, day));
    }

    return days;
  },

  get monthName() {
    return this.currentDate.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
  },

  previousMonth() {
    this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1, 1);
  },

  nextMonth() {
    this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 1);
  },

  selectDate(date) {
    this.selectedDate = date;
  },

  isToday(date) {
    const today = new Date();
    return date && date.toDateString() === today.toDateString();
  },

  isSelected(date) {
    return this.selectedDate && date && date.toDateString() === this.selectedDate.toDateString();
  },

  hasEvent(date) {
    return this.events.some(event => {
      const eventDate = new Date(event.date);
      return eventDate.toDateString() === date.toDateString();
    });
  }
}));

Alpine.data('timeSlots', () => ({
  slots: [],
  selectedSlot: null,
  loading: false,

  async loadSlots(date, therapistId) {
    this.loading = true;
    try {
      const response = await fetch(`/api/therapists/${therapistId}/availability?date=${date}`);
      const data = await response.json();
      this.slots = data.slots || [];
    } catch (error) {
      console.error('Error loading time slots:', error);
      this.slots = [];
    } finally {
      this.loading = false;
    }
  },

  selectSlot(slot) {
    this.selectedSlot = slot;
  },

  isSlotSelected(slot) {
    return this.selectedSlot && this.selectedSlot.id === slot.id;
  },

  isSlotDisabled(slot) {
    return slot.status === 'booked' || slot.status === 'unavailable';
  }
}));

Alpine.data('chat', () => ({
  messages: [],
  newMessage: '',
  typing: false,
  typingUsers: [],
  loading: false,

  async loadMessages(conversationId) {
    this.loading = true;
    try {
      const response = await fetch(`/api/conversations/${conversationId}/messages`);
      const data = await response.json();
      this.messages = data.messages || [];
      this.scrollToBottom();
    } catch (error) {
      console.error('Error loading messages:', error);
    } finally {
      this.loading = false;
    }
  },

  async sendMessage(conversationId) {
    if (!this.newMessage.trim()) return;

    const message = {
      content: this.newMessage.trim(),
      conversation_id: conversationId
    };

    try {
      const response = await fetch(`/api/conversations/${conversationId}/messages`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(message)
      });

      if (response.ok) {
        this.newMessage = '';
      }
    } catch (error) {
      console.error('Error sending message:', error);
    }
  },

  scrollToBottom() {
    this.$nextTick(() => {
      const chatContainer = this.$refs.chatContainer;
      if (chatContainer) {
        chatContainer.scrollTop = chatContainer.scrollHeight;
      }
    });
  },

  formatTime(timestamp) {
    return new Date(timestamp).toLocaleTimeString('en-US', {
      hour: '2-digit',
      minute: '2-digit'
    });
  }
}));

Alpine.data('videoCall', () => ({
  isCallActive: false,
  isMuted: false,
  isVideoOff: false,
  isScreenSharing: false,
  callDuration: 0,
  timer: null,

  startCall() {
    this.isCallActive = true;
    this.startTimer();
  },

  endCall() {
    this.isCallActive = false;
    this.stopTimer();
  },

  toggleMute() {
    this.isMuted = !this.isMuted;
  },

  toggleVideo() {
    this.isVideoOff = !this.isVideoOff;
  },

  toggleScreenShare() {
    this.isScreenSharing = !this.isScreenSharing;
  },

  startTimer() {
    this.timer = setInterval(() => {
      this.callDuration++;
    }, 1000);
  },

  stopTimer() {
    if (this.timer) {
      clearInterval(this.timer);
      this.timer = null;
    }
  },

  formatDuration(seconds) {
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const secs = seconds % 60;

    if (hours > 0) {
      return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }
    return `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
  }
}));

Alpine.data('search', () => ({
  query: '',
  results: [],
  loading: false,
  showResults: false,

  async search() {
    if (this.query.length < 2) {
      this.results = [];
      this.showResults = false;
      return;
    }

    this.loading = true;
    try {
      const response = await fetch(`/api/search?q=${encodeURIComponent(this.query)}`);
      const data = await response.json();
      this.results = data.results || [];
      this.showResults = true;
    } catch (error) {
      console.error('Error searching:', error);
      this.results = [];
    } finally {
      this.loading = false;
    }
  },

  selectResult(result) {
    this.query = result.name;
    this.showResults = false;
    // Navigate to result or perform action
    if (result.url) {
      window.location.href = result.url;
    }
  },

  clearSearch() {
    this.query = '';
    this.results = [];
    this.showResults = false;
  }
}));

// Utility functions
window.utils = {
  formatCurrency: (amount, currency = 'INR') => {
    return new Intl.NumberFormat('en-IN', {
      style: 'currency',
      currency: currency
    }).format(amount);
  },

  formatDate: (date, options = {}) => {
    const defaultOptions = {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    };
    return new Date(date).toLocaleDateString('en-US', { ...defaultOptions, ...options });
  },

  formatTime: (date, options = {}) => {
    const defaultOptions = {
      hour: '2-digit',
      minute: '2-digit'
    };
    return new Date(date).toLocaleTimeString('en-US', { ...defaultOptions, ...options });
  },

  debounce: (func, wait) => {
    let timeout;
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout);
        func(...args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  },

  throttle: (func, limit) => {
    let inThrottle;
    return function () {
      const args = arguments;
      const context = this;
      if (!inThrottle) {
        func.apply(context, args);
        inThrottle = true;
        setTimeout(() => (inThrottle = false), limit);
      }
    };
  }
};

// Initialize Alpine
Alpine.start();
