# 🎨 Animation Guide - Gracias Aesthetic Clinic

## 📋 Overview
Panduan ini menjelaskan semua animasi custom yang telah diterapkan pada aplikasi Laravel menggunakan **pure vanilla CSS** tanpa library eksternal seperti AOS.

## ⚡ Prinsip Animasi
- **Cepat**: Semua animasi di bawah 300ms
- **Smooth**: Menggunakan cubic-bezier easing functions
- **Tidak Mengganggu**: Animasi subtle yang meningkatkan UX
- **Accessible**: Mendukung `prefers-reduced-motion`

---

## 🎯 Keyframes Animations

### 1. Fade In
```css
.animate-fade-in
```
- **Duration**: 250ms
- **Use Case**: Headers, alerts, modals
- **Effect**: Fade dari opacity 0 ke 1

### 2. Slide Up
```css
.animate-slide-up
```
- **Duration**: 280ms
- **Use Case**: Cards, sections, content blocks
- **Effect**: Slide dari bawah sambil fade in

### 3. Slide Down
```css
.animate-slide-down
```
- **Duration**: 280ms
- **Use Case**: Notifications, dropdown menus
- **Effect**: Slide dari atas sambil fade in

### 4. Slide Left/Right
```css
.animate-slide-left
.animate-slide-right
```
- **Duration**: 280ms
- **Use Case**: Sidebar, navigation panels
- **Effect**: Slide dari samping sambil fade in

### 5. Scale In
```css
.animate-scale-in
```
- **Duration**: 250ms
- **Use Case**: Buttons, badges, small elements
- **Effect**: Scale dari 0.95 ke 1 sambil fade in

### 6. Bounce In
```css
.animate-bounce-in
```
- **Duration**: 300ms
- **Use Case**: Success messages, achievements
- **Effect**: Bounce effect saat muncul

---

## ⏱️ Stagger Delays

Untuk membuat animasi berurutan (staggered), gunakan delay classes:

```css
.delay-75   /* 75ms delay */
.delay-100  /* 100ms delay */
.delay-150  /* 150ms delay */
.delay-200  /* 200ms delay */
.delay-250  /* 250ms delay */
.delay-300  /* 300ms delay */
```

**Contoh Penggunaan:**
```html
<div class="animate-slide-up">Card 1</div>
<div class="animate-slide-up delay-100">Card 2</div>
<div class="animate-slide-up delay-200">Card 3</div>
```

---

## 🎭 Hover Effects

### 1. Lift Effect
```css
.hover-lift
```
- **Effect**: Element naik 4px saat hover
- **Use Case**: Cards, buttons, clickable items
- **Transition**: 200ms

### 2. Scale
```css
.hover-scale      /* Scale 1.05 */
.hover-scale-sm   /* Scale 1.02 */
```
- **Effect**: Element membesar saat hover
- **Use Case**: Images, icons, small buttons

### 3. Glow
```css
.hover-glow
```
- **Effect**: Box shadow glow dengan theme color
- **Use Case**: Primary actions, featured items

### 4. Brightness
```css
.hover-brightness
```
- **Effect**: Brightness filter 1.1
- **Use Case**: Images, thumbnails

---

## 👆 Click/Active Effects

### Active Press
```css
.active-press
```
- **Effect**: Scale 0.97 saat diklik
- **Use Case**: Semua buttons dan clickable elements
- **Transition**: 100ms (sangat cepat)

---

## 🔄 Smooth Transitions

### Standard Transitions
```css
.transition-smooth       /* 200ms */
.transition-smooth-fast  /* 150ms */
```
- **Easing**: cubic-bezier(0.16, 1, 0.3, 1)
- **Use Case**: Color changes, transforms, opacity

---

## 📍 Implementation Examples

### Dashboard Cards (Staggered Animation)
```html
<div class="bg-card animate-slide-up hover-lift transition-smooth">
    Card 1
</div>
<div class="bg-card animate-slide-up delay-100 hover-lift transition-smooth">
    Card 2
</div>
<div class="bg-card animate-slide-up delay-200 hover-lift transition-smooth">
    Card 3
</div>
```

### Buttons
```html
<!-- Primary Button -->
<button class="bg-primary hover:bg-primary/90 transition-smooth hover-lift active-press">
    Submit
</button>

<!-- Action Button -->
<button class="bg-blue-600 hover:bg-blue-700 transition-smooth hover-scale-sm active-press">
    Edit
</button>
```

### Navigation Links
```html
<a href="#" class="hover-scale-sm active-press transition-smooth">
    Menu Item
</a>
```

### Treatment Cards
```html
<div class="bg-card animate-slide-up hover-lift transition-smooth">
    <img class="transition-smooth group-hover:scale-110" />
    <button class="hover-scale-sm active-press">View Details</button>
</div>
```

### Alerts/Notifications
```html
<div class="bg-green-50 animate-slide-down">
    Success message
</div>
```

---

## 🏗️ File Structure

### Animations Defined In:
```
resources/css/app.css
```

### Applied To:
- ✅ `resources/views/admin/dashboard.blade.php` - Dashboard cards & charts
- ✅ `resources/views/reservasi/admin.blade.php` - Reservasi table & stats
- ✅ `resources/views/treatments/manage.blade.php` - Treatment cards
- ✅ `resources/views/partials/sidebar.blade.php` - Sidebar navigation
- ✅ `resources/views/partials/navbar.blade.php` - Main navigation

---

## ♿ Accessibility

Semua animasi otomatis dinonaktifkan untuk user yang mengaktifkan `prefers-reduced-motion`:

```css
@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
  }
}
```

---

## 🎨 Best Practices

### ✅ DO:
1. Kombinasikan `hover-lift` dengan `transition-smooth` untuk smooth interaction
2. Gunakan `active-press` pada semua clickable elements
3. Terapkan stagger delays pada lists/grids untuk efek cascade
4. Gunakan `animate-fade-in` untuk headers
5. Gunakan `animate-slide-up` untuk cards/content blocks

### ❌ DON'T:
1. Jangan stack terlalu banyak animasi pada 1 element
2. Jangan gunakan delay > 300ms (terlalu lambat)
3. Jangan lupa `transition-smooth` saat pakai hover effects
4. Jangan gunakan `bounce-in` terlalu sering (hanya untuk moments spesial)

---

## 📊 Performance Tips

1. **Use `will-change` sparingly**: Hanya untuk animasi complex
2. **Prefer transforms over position**: Transform lebih performant
3. **Keep duration < 300ms**: Untuk feel responsive
4. **Use GPU acceleration**: Transform dan opacity di-handle GPU

---

## 🔧 Customization

Untuk modify timing/easing, edit di `resources/css/app.css`:

```css
/* Contoh: Ubah duration */
.animate-slide-up {
  animation: slideUp 280ms cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

/* Contoh: Ubah easing */
.transition-smooth {
  transition: all 200ms cubic-bezier(0.4, 0, 0.2, 1);
}
```

---

## 📝 Notes

- Semua animasi menggunakan **forwards** untuk maintain final state
- Alpine.js transitions di navbar menggunakan custom timing yang sama
- Theme colors dari CSS variables (`var(--primary)`, etc.)
- Compatible dengan Tailwind CSS v4

---

**Created by**: Dhika Mahesa
**Last Updated**: November 5, 2025
**Version**: 1.0.0
