# How Your 3 PM Session Works - Complete Guide

## 📋 Overview

This guide explains the complete workflow for a session created at 3 PM today, from booking to completion.

---

## 🔄 Complete Session Workflow

### **Step 1: Session Creation (Already Done) ✅**

When you created the session at 3 PM:

- ✅ Appointment was created with status: **`scheduled`**
- ✅ Twilio video/audio room was created
- ✅ Meeting ID and link were generated
- ✅ Session is stored in database

**Current Status:** `scheduled` (waiting for payment and admin activation)

---

### **Step 2: Payment Process 💳**

**What Happens:**

1. After booking, you're redirected to the payment page
2. You need to complete payment to confirm the booking
3. Payment can be done via:
   - Wallet (if you have sufficient balance)
   - Razorpay
   - Stripe

**After Payment:**

- ✅ Payment status: `completed`
- ✅ Appointment status remains: `scheduled` (until admin activates)
- ✅ Client and therapist receive notifications

**Action Required:** Complete payment if not done yet.

---

### **Step 3: Admin Activation (SuperAdmin) 👨‍💼**

**What Happens:**

- SuperAdmin must activate the session before it becomes available
- Admin goes to: **Admin Panel → Appointments**
- Finds your 3 PM session
- Clicks **"Activate"** button

**After Activation:**

- ✅ `is_activated_by_admin` = `true`
- ✅ Therapist receives notification about the session
- ✅ Session becomes visible to therapist
- ✅ Status remains: `scheduled` (until join time)

**Action Required:** Ask SuperAdmin to activate your session.

---

### **Step 4: Automatic Activation (5 Minutes Before) ⏰**

**What Happens Automatically:**

- A scheduled command runs every minute: `sessions:activate`
- At **2:55 PM** (5 minutes before 3 PM):
  - System checks if session time is within 5 minutes
  - If `is_activated_by_admin` = `true`:
    - Status changes: `scheduled` → **`confirmed`**
  - Join button becomes available for both client and therapist

**Timeline:**

- **2:55 PM**: Status → `confirmed` (Join button appears)
- **3:00 PM**: Status → `in_progress` (when someone joins)

**No Action Required:** This happens automatically if cron is running.

---

### **Step 5: Joining the Session (2:55 PM onwards) 🎥**

#### **For Client:**

1. Go to: **My Sessions** or **My Appointments**
2. Find your 3 PM session
3. Click **"Join Session"** button (available from 2:55 PM)
4. You'll be taken to the video/audio call interface
5. Status automatically changes to: `in_progress`

#### **For Therapist:**

1. Go to: **My Sessions** or **Dashboard**
2. Find the 3 PM session
3. Click **"Join Session"** button (available from 2:55 PM)
4. You'll be taken to the video/audio call interface
5. Status automatically changes to: `in_progress`

**Important Rules:**

- ✅ Join button appears **5 minutes before** scheduled time (2:55 PM)
- ✅ Both client and therapist can join
- ✅ Therapist can only join ONE session at a time
- ✅ If therapist has another active session, they must complete it first

---

### **Step 6: During the Session 🎬**

**What Happens:**

- Status: `in_progress`
- Both participants are in the Twilio video/audio room
- Session duration is tracked
- Real-time communication via Twilio

**Features:**

- Video call (if `session_mode` = `video`)
- Audio call (if `session_mode` = `audio`)
- Chat (if `session_mode` = `chat`)

---

### **Step 7: Ending the Session 🏁**

**Automatic Ending:**

- System checks every minute for expired sessions
- When session duration ends (e.g., after 60 minutes):
  - Status changes: `in_progress` → **`completed`**
  - Payment is processed (deducted from client wallet)
  - Therapist earnings are recorded
  - Both parties receive completion notifications

**Manual Ending:**

- Either party can click "End Session" button
- Status changes to: `completed`
- Payment is processed immediately

**After Completion:**

- ✅ Status: `completed`
- ✅ Payment deducted from client wallet
- ✅ Therapist earnings recorded
- ✅ Client can leave a review

---

## 📊 Session Status Flow

```
scheduled → confirmed → in_progress → completed
    ↓           ↓            ↓            ↓
  Created   5 min before   Someone      Duration
            (2:55 PM)      joins        ends
```

---

## ⚙️ Automated Processes

### **1. Session Activation Command**

- **Command:** `php artisan sessions:activate`
- **Runs:** Every minute (via Laravel Scheduler)
- **What it does:**
  - Checks for sessions 5 minutes before scheduled time
  - Changes status: `scheduled` → `confirmed`
  - Auto-starts session when time arrives

### **2. Session Ending Command**

- **Command:** `php artisan sessions:end`
- **Runs:** Every minute (via Laravel Scheduler)
- **What it does:**
  - Checks for expired sessions
  - Changes status: `in_progress` → `completed`
  - Processes payment

### **3. Reminder Notifications**

- **Command:** `php artisan sessions:remind`
- **Runs:** Every minute
- **What it does:**
  - Sends reminders 15 minutes before session time

---

## 🔍 How to Check Your Session Status

### **For Client:**

1. Go to: **My Sessions** (`/sessions`)
2. Or: **My Appointments** (`/appointments`)
3. Find your 3 PM session
4. Check the status badge:
   - 🟡 **Scheduled** = Waiting for activation/confirmation
   - 🟢 **Confirmed** = Ready to join (5 min before)
   - 🔵 **In Progress** = Currently active
   - 🟣 **Completed** = Finished

### **For Therapist:**

1. Go to: **My Sessions** (`/therapist/sessions`)
2. Or: **Dashboard** (`/therapist/dashboard`)
3. Find the 3 PM session
4. Check the status badge

### **For Admin:**

1. Go to: **Admin → Appointments**
2. Find the 3 PM session
3. Check status and activate if needed

---

## ⚠️ Important Notes

### **Join Button Rules:**

- ✅ Appears **5 minutes before** scheduled time (2:55 PM for 3 PM session)
- ✅ Only for `video` and `audio` session modes
- ✅ Requires status: `confirmed` or `in_progress`
- ✅ Requires: `is_activated_by_admin` = `true`

### **Therapist Limitations:**

- ❌ Therapist can only have **ONE active session** at a time
- ❌ If therapist tries to join another session while one is active, they'll get an error
- ✅ Must complete current session before starting a new one

### **Payment Requirements:**

- ✅ Payment must be completed before session can be activated
- ✅ Payment is deducted when session is completed
- ✅ If payment fails, session cannot proceed

---

## 🛠️ Troubleshooting

### **Join Button Not Showing:**

1. Check if it's 5 minutes before scheduled time
2. Check if admin has activated the session
3. Check if payment is completed
4. Check if session mode is `video` or `audio`

### **Session Not Activating:**

1. Check if cron job is running: `php artisan schedule:list`
2. Manually activate: `php artisan sessions:activate --force`
3. Check appointment date and time in database

### **Therapist Can't Join:**

1. Check if therapist has another active session
2. Complete the other session first
3. Then try joining again

---

## 📝 Quick Checklist for Your 3 PM Session

- [ ] ✅ Session created (Done)
- [ ] ⏳ Payment completed?
- [ ] ⏳ Admin activated session?
- [ ] ⏳ Wait until 2:55 PM (5 min before)
- [ ] ⏳ Join button appears
- [ ] ⏳ Client joins session
- [ ] ⏳ Therapist joins session
- [ ] ⏳ Session in progress
- [ ] ⏳ Session completes automatically
- [ ] ⏳ Payment processed
- [ ] ⏳ Review can be left

---

## 🎯 Current Status Check

To check your session right now, run:

```bash
php artisan tinker
```

Then:

```php
$session = App\Models\Appointment::where('appointment_time', 'like', '%15:00%')
    ->whereDate('appointment_date', today())
    ->first();

echo "Status: " . $session->status . "\n";
echo "Activated by Admin: " . ($session->is_activated_by_admin ? 'Yes' : 'No') . "\n";
echo "Payment: " . ($session->payment ? $session->payment->status : 'Not paid') . "\n";
```

---

## 📞 Need Help?

If you encounter any issues:

1. Check the session status in the database
2. Verify cron jobs are running
3. Check admin activation status
4. Verify payment completion
5. Check join button timing (5 minutes before)

---

**Last Updated:** Today
**Session Time:** 3:00 PM
**Join Available From:** 2:55 PM (5 minutes before)
