# Setting IST Timezone - Complete Guide

## ✅ **Changes Made**

### **1. Application Timezone Configuration**
- Updated `config/app.php` to default to `Asia/Kolkata` (IST)
- Set in `AppServiceProvider` to ensure Carbon uses IST globally

### **2. Global Timezone Setup**
- Added timezone setting in `AppServiceProvider::boot()`
- All Carbon instances now default to IST

### **3. Updated Views**
- All date/time calculations now use IST
- All time displays show IST timezone

## 🔧 **Configuration**

### **In `.env` file:**
```env
APP_TIMEZONE=Asia/Kolkata
```

### **In `config/app.php`:**
```php
'timezone' => env('APP_TIMEZONE', 'Asia/Kolkata'),
```

### **In `app/Providers/AppServiceProvider.php`:**
```php
public function boot(): void
{
    Schema::defaultStringLength(191);
    
    // Set default timezone to IST (Indian Standard Time)
    date_default_timezone_set(config('app.timezone', 'Asia/Kolkata'));
    
    // Set Carbon default timezone to IST
    \Carbon\Carbon::setTimezone(config('app.timezone', 'Asia/Kolkata'));
}
```

## 📍 **What Shows IST Now**

1. ✅ **Session Times** - All appointment times show in IST
2. ✅ **Join Button Availability** - "Available at 2:55 PM IST"
3. ✅ **Therapist Availability** - All availability slots show in IST
4. ✅ **Dashboard Times** - All times on dashboards show in IST
5. ✅ **Real-time Calculations** - All time differences calculated in IST

## 🎯 **Example**

**Before:**
- Appointment: 3:00 PM UTC
- Current: 11:00 AM UTC
- Shows: "Available 4 hours from now"

**After:**
- Appointment: 3:00 PM IST
- Current: 11:00 AM IST
- Shows: "Join button will be available in 3 hours 55 minutes (at 2:55 PM IST)"

## 🔄 **To Apply Changes**

1. **Update `.env` file:**
   ```env
   APP_TIMEZONE=Asia/Kolkata
   ```

2. **Clear caches:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

3. **Restart server** (if using queue workers or scheduled tasks)

## ✅ **Verification**

Check that times are showing in IST:
- Go to any session/appointment page
- Check the time display - should show IST
- Check "Available at" messages - should show IST timezone

---

**Last Updated:** Today
**Status:** ✅ Configured for IST
