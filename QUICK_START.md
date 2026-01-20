# CCTV PMS - Quick Start Guide 🚀

## सबसे पहले क्या करें?

### 1️⃣ Installation (पहली बार)
```bash
cd c:\xampp\htdocs\cctv-pms

# सभी packages install करें
composer install
npm install

# Database तैयार करें
php artisan migrate
php artisan db:seed

# Key generate करें
php artisan key:generate
```

### 2️⃣ Server Start करें
```bash
# Terminal 1 - Backend
php artisan serve

# Terminal 2 - Frontend (दूसरी window में)
npm run dev

# अब खोलें: http://localhost:8000
```

---

## 👤 Default Login Credentials

```
🔴 MASTER ADMIN (सबसे ज्यादा अधिकार)
   Email: master@admin.com
   Password: password
   Access: System Settings, Company Profile, Financial Reports, Admin Management

🟡 ADMIN (Approvals देता है)
   Email: admin@admin.com
   Password: password
   Access: Approve Purchases/Sales, View Reports, Manage Products

🟢 USER (Purchases/Sales/Payments करता है)
   Email: user@example.com
   Password: password
   Access: Create Purchases, Sales, Payments, Manage Inventory
```

---

## 📊 Project का Basic Flow

```
┌─────────────┐
│   USER      │
│   (आप)     │
└──────┬──────┘
       │
       ├─► Create Purchase ──► Status: Pending
       ├─► Create Sale ──► Status: Pending
       ├─► Record Payment
       └─► Manage Inventory
       
       │
       ▼
┌─────────────────┐
│  DATABASE       │
│  (सभी Data)    │
└────────┬────────┘
       │
       ▼
┌──────────────────┐
│  ADMIN PANEL     │
│  (Approvals)     │
└────────┬─────────┘
       │
       ├─► Approve Purchase ──► Status: Approved ✅
       └─► Approve Sale ──► Status: Approved ✅
       
       │
       ▼
┌──────────────────┐
│  REPORTS         │
│  (Numbers/Data)  │
└──────────────────┘
```

---

## 🎯 क्या-क्या कर सकते हो?

### Purchase (खरीद) 🛒
```
✅ नई खरीद add करना
   User Panel → Purchases → Add Purchase
   → Product चुनना
   → Quantity डालना
   → Cost डालना
   → Save करना

✅ खरीद को Edit करना (Pending होने तक)
✅ खरीद को Delete करना (Pending होने तक)
✅ अपनी सभी Purchases देखना
✅ Status track करना (Pending/Approved)
```

### Sale (बिक्री) 📊
```
✅ नई बिक्री add करना
   User Panel → Sales → Add Sale
   → Product चुनना
   → Quantity डालना
   → Price डालना
   → Save करना

✅ बिक्री को Edit करना
✅ बिक्री को Delete करना
✅ सभी Sales देखना
✅ Total Amount calculate होना automatically
```

### Payment (भुगतान) 💰
```
✅ Payment record करना
   User Panel → Payments → Add Payment
   → Sale चुनना
   → Amount डालना
   → Method चुनना (Cash/UPI/Bank)
   → Save करना

✅ Payment को Edit करना
✅ Payment को Delete करना
✅ सभी Payments की history
```

### Inventory (स्टॉक) 📦
```
✅ नया Product add करना
   User Panel → Inventory → Add Product
   → Product name
   → SKU (unique code)
   → Price
   → Stock quantity
   → Save करना

✅ Product को Edit करना
✅ Product को Delete करना
✅ Stock status देखना (Low/Good/Out of Stock)
✅ Purchase/Sale count देखना
```

### Admin Approvals ✅
```
🔑 Admin के लिए:
   Admin Panel → Approvals
   
   → सभी Pending Purchases देखना
   → सभी Pending Sales देखना
   → Approve करना
   → Reject करना
   
   → Admin Panel → Reports
      सभी data की reports देख सकता है
      CSV में export कर सकता है
```

### Master Admin Functions 👑
```
👑 Master Admin के लिए:
   Admin Panel → System Settings
   → App settings बदलना
   
   Admin Panel → Company Profile
   → Company की information
   → Logo/Details
   
   Admin Panel → Financial Reports
   → Income/Expense track करना
   → Detailed reports
   
   Admin Panel → Admins
   → नए Admins add करना
   → Admins को manage करना
```

---

## 🗂️ File कहाँ क्या है?

```
📁 app/Models/                    ← Database से connect करने के लिए
   ├── Purchase.php               ← खरीद का Model
   ├── Sale.php                   ← बिक्री का Model
   ├── Payment.php                ← भुगतान का Model
   ├── Product.php                ← सामान का Model
   └── User.php                   ← यूजर्स का Model

📁 app/Http/Controllers/          ← Business Logic
   ├── PurchaseController.php     ← खरीद की functionality
   ├── SalesController.php        ← बिक्री की functionality
   ├── PaymentController.php      ← भुगतान की functionality
   ├── InventoryController.php    ← स्टॉक की functionality
   └── ...

📁 resources/views/               ← Webpages (HTML)
   └── 📁 user/
       ├── 📁 purchases/
       │   ├── index.blade.php    ← खरीद की list
       │   ├── create.blade.php   ← नई खरीद form
       │   └── edit.blade.php     ← खरीद को edit करने के लिए
       ├── 📁 sales/              ← बिक्री के pages
       ├── 📁 payments/           ← भुगतान के pages
       └── 📁 inventory/          ← स्टॉक के pages

📁 database/migrations/           ← Database tables structure
   ├── ...create_purchases_table.php
   ├── ...create_sales_table.php
   ├── ...create_payments_table.php
   └── ...create_products_table.php

📁 routes/
   └── web.php                    ← सभी URLs/Links यहाँ हैं

📁 public/
   └── index.php                  ← Website का Entry Point
```

---

## 🔄 Purchase का Complete Example

### Step 1: User Form भरता है
```
User Panel → Purchases → "Add Purchase" Button Click
↓
Form खुलता है:
  • Product: Laptop
  • Quantity: 5
  • Cost per Unit: 50,000
  • Total: 2,50,000
↓
"Save Purchase" Click करता है
```

### Step 2: Database में Save होता है
```
purchases table में:
id          1
product_id  5
quantity    5
cost        50000
created_by  3 (User की ID)
status      pending
created_at  2026-01-20 10:30:00
```

### Step 3: User को दिखता है
```
Purchases List:
ID    Product    Qty   Cost/Unit   Total         Status    Actions
1     Laptop     5     ₹50,000     ₹2,50,000     🟡Pending  Edit Delete
```

### Step 4: Admin को दिखता है
```
Admin Panel → Approvals:
Purchase #1 - Laptop (Qty: 5) - ₹2,50,000
Created By: User Name
Created On: 20 Jan 2026

[Approve Button]  [Reject Button]
```

### Step 5: Admin Approve करता है
```
Admin → "Approve" Button Click
↓
status = 'approved'
↓
User को दिखता है:
ID    Product    Qty   Cost/Unit   Total         Status    Actions
1     Laptop     5     ₹50,000     ₹2,50,000     ✅Approved No Actions
```

---

## 🛠️ Useful Commands

```bash
# Database Commands
php artisan migrate                  # Tables बनाएं
php artisan migrate:fresh           # सब delete करके नए बनाएं
php artisan db:seed                 # Dummy data डालें
php artisan db:seed --class=AdminSeeder  # सिर्फ Admin seed करें

# Server
php artisan serve                   # Server start करें (http://localhost:8000)

# Frontend
npm run dev                         # CSS/JS को watch करना
npm run build                       # Production के लिए build करना

# Cache & Config
php artisan cache:clear            # Cache clear करें
php artisan config:cache           # Config cache करें
php artisan view:clear             # View cache clear करें

# Tinker (Interactive Shell)
php artisan tinker                 # Interactive PHP shell
# Example:
# >>> User::all()              - सभी users
# >>> User::find(1)            - ID 1 वाला user
# >>> Purchase::count()        - कितने purchases हैं
```

---

## 🐛 Common Issues & Solutions

### Issue 1: "SQLSTATE[HY000]: General error: 1 unable to open database file"
```bash
# Solution:
php artisan migrate:fresh
php artisan db:seed
```

### Issue 2: "No such file or directory" (CSS/JS नहीं मिल रहा)
```bash
# Solution:
npm run build
php artisan config:cache
php artisan cache:clear
```

### Issue 3: Login नहीं हो रहा है
```bash
# Solution:
1. Check करें: php artisan migrate (migrations run हुए?)
2. Check करें: php artisan db:seed (data आया?)
3. .env file check करें (database सही है?)
```

### Issue 4: "419 Page Expired" (CSRF Token Error)
```bash
# Solution:
php artisan config:cache
php artisan cache:clear

# या .env में
php artisan key:generate
```

---

## 📝 Code Examples

### Purchase Create करना (Backend Logic)
```php
// PurchaseController.php में

public function store(Request $request)
{
    // Input validate करना
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'cost' => 'required|numeric|min:0.01',
    ]);

    // Current user की ID add करना
    $validated['created_by'] = Auth::id();
    $validated['status'] = 'pending';

    // Database में save करना
    Purchase::create($validated);

    // Success message के साथ redirect करना
    return redirect()->route('user.purchases.index')
        ->with('success', 'Purchase created successfully');
}
```

### Purchase List दिखाना (Frontend)
```blade
<!-- purchases/index.blade.php में -->

@foreach($purchases as $purchase)
    <tr>
        <td>#{{ $purchase->id }}</td>
        <td>{{ $purchase->product->name }}</td>
        <td>{{ $purchase->quantity }}</td>
        <td>₹{{ $purchase->cost }}</td>
        <td>₹{{ $purchase->quantity * $purchase->cost }}</td>
        <td>
            @if($purchase->status === 'pending')
                <span class="badge bg-warning">Pending</span>
            @else
                <span class="badge bg-success">Approved</span>
            @endif
        </td>
    </tr>
@endforeach
```

---

## 🎓 Learning Path

```
शुरुआत करने के लिए यह क्रम follow करें:

1️⃣ Installation & Setup
   ↓
2️⃣ Dashboard को समझना
   ↓
3️⃣ Purchase functionality सीखना
   ↓
4️⃣ Sales functionality सीखना
   ↓
5️⃣ Payment system समझना
   ↓
6️⃣ Inventory management सीखना
   ↓
7️⃣ Admin Approvals को समझना
   ↓
8️⃣ Reports देखना
   ↓
9️⃣ Master Admin features
   ↓
🔟 Production में deploy करना
```

---

## 📌 Important Files to Know

| File | क्या करता है |
|------|-------------|
| `routes/web.php` | सभी URLs/Links यहाँ define हैं |
| `app/Http/Controllers/` | सभी business logic यहाँ |
| `app/Models/` | Database tables से connection |
| `resources/views/` | HTML pages |
| `database/migrations/` | Database structure |
| `.env` | Environment variables |
| `composer.json` | PHP dependencies |
| `package.json` | JavaScript dependencies |

---

## ✅ Checklist - Project Complete करने के लिए

```
□ Installation complete किया
□ Database migrations run किए
□ Seeders से dummy data डाला
□ npm run dev/build चलाया
□ localhost:8000 पर खोला
□ Master Admin से login किया
□ Admin से login किया
□ User से login किया
□ Purchase create किया
□ Sale create किया
□ Payment create किया
□ Product add किया
□ Admin से Approve किया
□ Reports देखे
□ सब काम कर रहे हैं ✅

आपका Project Complete है! 🎉
```

---

## 🚀 अगले Steps

```
अब आप कर सकते हो:

1. अपने requirements के हिसाब से customize करना
2. नए features add करना
3. Design को अपने हिसाब से बदलना
4. Database में और tables add करना
5. Reports को और detailed बनाना
6. Mobile app बनाना (API से connect करके)
7. Email notifications add करना
8. Payment gateway integrate करना (Stripe/PayPal)
9. Production में deploy करना
10. Team members को onboard करना
```

---

## 💡 Pro Tips

```
1. हमेशा .env file में APP_DEBUG=true रखें (development में)
2. Regular database backups लें
3. Code को git पर push करते रहें
4. Comments लिखते रहें अपने code में
5. Testing करते रहें नए features को
6. Error logs को देखते रहें
7. Users का feedback लें
8. Performance optimize करते रहें
9. Security updates देते रहें
10. Documentation update करते रहें
```

---

## 📞 Help & Support

अगर कोई issue आए तो:

```
1. Error message को ध्यान से पढ़ें
2. Laravel logs देखें: storage/logs/laravel.log
3. Browser console खोलें (F12)
4. .env file check करें
5. Database connections verify करें
6. Laravel documentation देखें: laravel.com/docs
7. Google पर search करें error message को
```

---

## 🎉 Congratulations!

अब आपका **CCTV PMS** Project पूरी तरह से तैयार है!

**आप कर सकते हो:**
- ✅ खरीद/बिक्री का सिस्टम चला सकते हो
- ✅ भुगतान को track कर सकते हो  
- ✅ स्टॉक को manage कर सकते हो
- ✅ Approvals दे सकते हो
- ✅ Reports generate कर सकते हो
- ✅ पूरा business को digitize कर सकते हो

**Happy Coding! 🚀**

For more details, see: PROJECT_OVERVIEW_HINDI.md