# How to Join Session Room - Complete Guide

## 🎯 Overview

This guide explains how both **Client** and **Therapist** can join video/audio session rooms.

---

## ✅ Prerequisites

Before joining, ensure:

1. ✅ **Session is activated by SuperAdmin** (`is_activated_by_admin = true`)
2. ✅ **Payment is completed** (for client)
3. ✅ **Time is within 5 minutes** before scheduled time (2:55 PM for 3 PM session)
4. ✅ **Status is `confirmed` or `in_progress`**
5. ✅ **Session mode is `video` or `audio`**

---

## 📍 Where to Find Join Button

### **For Client:**

1. **My Sessions Page** (`/sessions`)

   - Go to: **My Sessions** from menu
   - Find your session card
   - Click **"Join Session"** button (appears when conditions are met)

2. **My Appointments Page** (`/appointments`)

   - Go to: **My Appointments** from menu
   - Find your appointment card
   - Click **"Join Session"** button

3. **Appointment Details Page** (`/appointments/{id}`)

   - Click on any appointment
   - Click **"Join Session Now"** button at the top
   - Or **"Join Session"** button at the bottom

4. **Dashboard** (`/dashboard`)
   - Scroll to "Today's Sessions" section
   - Click **"Join Session Now"** button

### **For Therapist:**

1. **My Sessions Page** (`/therapist/sessions`)

   - Go to: **My Sessions** from therapist menu
   - Find the session in the table
   - Click **"Join Session"** button (appears when conditions are met)

2. **Dashboard** (`/therapist/dashboard`)
   - Scroll to "Today's Sessions" section
   - Click **"Join Session"** button

---

## 🔄 Join Button Logic

The join button appears when **ALL** of these conditions are met:

```php
$canJoin = $appointmentDateTime->diffInMinutes(now(), false) >= -5; // 5 min before
$isActive = $canJoin
    && in_array($session->session_mode, ['video', 'audio'])
    && $session->is_activated_by_admin
    && (
        in_array($session->status, ['confirmed', 'in_progress']) ||
        ($session->status === 'scheduled' && $appointmentDateTime->isPast())
    );
```

**Conditions:**

- ✅ Time is 5 minutes before or after scheduled time
- ✅ Session mode is `video` or `audio`
- ✅ Admin has activated the session
- ✅ Status is `confirmed`, `in_progress`, or `scheduled` (if time has passed)

---

## 🚀 How to Join

### **Step 1: Click Join Button**

- Find the session/appointment
- Click the **"Join Session"** button

### **Step 2: You'll be Redirected**

- URL: `/sessions/join/{appointment_id}`
- Controller: `SessionController@join`
- View: `resources/views/sessions/join.blade.php`

### **Step 3: Session Room Loads**

- Twilio video/audio room interface loads
- Access token is generated automatically
- Room connection is established

### **Step 4: Start Session**

- Video/Audio controls appear
- You can toggle video/audio
- Other participant can join

---

## 🎥 Session Room Features

### **Video Controls:**

- **Toggle Video** - Turn camera on/off
- **Toggle Audio** - Turn microphone on/off
- **End Session** - Leave the session

### **Session Info:**

- Session ID
- Date & Time
- Duration
- Mode (Video/Audio)
- Your Role (Client/Therapist)
- Time Remaining

---

## ⚠️ Important Notes

### **Therapist Limitations:**

- ❌ Therapist can only join **ONE session at a time**
- ❌ If therapist tries to join another session while one is active, they'll get an error
- ✅ Must complete current session before starting a new one

### **Time Restrictions:**

- ✅ Join button appears **5 minutes before** scheduled time
- ✅ Can join anytime after scheduled time
- ❌ Cannot join more than 5 minutes early

### **Admin Activation:**

- ✅ Session must be activated by SuperAdmin first
- ✅ Without activation, join button won't appear
- ✅ Check status in Admin Panel → Online Sessions

---

## 🛠️ Troubleshooting

### **Join Button Not Showing:**

1. **Check Admin Activation:**

   ```bash
   # In database or admin panel
   is_activated_by_admin = true
   ```

2. **Check Time:**

   - Must be 5 minutes before scheduled time
   - Current time: Check system clock
   - Scheduled time: Check appointment time

3. **Check Status:**

   - Should be `confirmed` or `in_progress`
   - If `scheduled`, time must have passed

4. **Check Session Mode:**

   - Must be `video` or `audio`
   - `chat` mode doesn't have join button

5. **Check Payment:**
   - Client must have completed payment
   - Check payment status in appointment

### **Cannot Join (Error Messages):**

**"This session has not been activated by admin yet"**

- Solution: Ask SuperAdmin to activate the session

**"This session is not available to join yet"**

- Solution: Wait until status is `confirmed` or `in_progress`

**"Session will be available 10 minutes before the scheduled time"**

- Solution: Wait until 5 minutes before (this message is outdated, actual is 5 min)

**"You already have an active session"** (Therapist only)

- Solution: Complete the current active session first

### **Session Room Not Loading:**

1. **Check Twilio Configuration:**

   ```bash
   php artisan config:show twilio
   ```

2. **Check Browser Console:**

   - Open browser developer tools (F12)
   - Check for JavaScript errors
   - Check network requests

3. **Check Twilio Credentials:**

   - Account SID is set
   - Auth Token is set
   - API Key SID and Secret are set (for video)

4. **Check Network:**
   - Ensure stable internet connection
   - Check firewall settings
   - Try different browser

---

## 📝 Quick Checklist

Before joining, verify:

- [ ] Session is activated by admin
- [ ] Payment is completed (client)
- [ ] Time is within 5 minutes before scheduled time
- [ ] Status is `confirmed` or `in_progress`
- [ ] Session mode is `video` or `audio`
- [ ] Therapist doesn't have another active session
- [ ] Twilio credentials are configured

---

## 🔗 Routes

**Join Session Route:**

```
GET /sessions/join/{appointment}
Route Name: sessions.join
Controller: App\Http\Controllers\SessionController@join
```

**Get Token Route:**

```
GET /sessions/token/{appointment}
Route Name: sessions.token
Controller: App\Http\Controllers\SessionController@getToken
```

**End Session Route:**

```
POST /sessions/end/{appointment}
Route Name: sessions.end
Controller: App\Http\Controllers\SessionController@end
```

---

## 🎯 Testing

To test the join functionality:

1. **Create a test session:**

   - Book an appointment for current time + 10 minutes

2. **Activate it:**

   - Admin Panel → Online Sessions
   - Click Actions → Activate Session

3. **Wait 5 minutes:**

   - Or manually activate: `php artisan sessions:activate --force --id={appointment_id}`

4. **Join:**
   - Click "Join Session" button
   - Should redirect to session room
   - Twilio interface should load

---

**Last Updated:** Today
**Route:** `/sessions/join/{appointment}`
**Controller:** `SessionController@join`
**View:** `resources/views/sessions/join.blade.php`
