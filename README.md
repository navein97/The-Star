# Front-End Developer Practical Test Solution

This repository contains the completed code for the "Job Fair Web Application" and "Spinning Wheel Game" practical test assignments.

## 🚀 Quick Start (Read This First)

**Important:** You must navigate into the project directory before running commands. The root folder is just a container.

### 1. Job Fair App (Vue 3 + Tailwind)
To run the main application:
```bash
# 1. Enter the project folder (CRITICAL STEP)
cd job-fair-app

# 2. Install dependencies
npm install

# 3. Start the development server
npm run dev
```
> Access the app at `http://localhost:3000` (or the port shown in your terminal).

### 2. PHP Backend (Optional for UI Demo)
To make the forms work nicely with a real database:
```bash
# In a separate terminal window:
cd job-fair-app
php -S localhost:8000
```
> *Note: The app has a "Demo Mode" so you can test the UI without this backend running.*

---

## 📂 Project Structure

```
/
├── job-fair-app/           # Assignment #1: Vue.js Web Application
│   ├── src/                # Vue source code (Tailwind, Components)
│   ├── backend/            # PHP API endpoints
│   ├── database/           # SQL schema
│   ├── postcss.config.cjs  # PostCSS Config
│   └── tailwind.config.cjs # Tailwind Config
└── spinning-wheel-game/    # Assignment #2: HTML5 Canvas Game
    ├── data/               # Prize configuration JSON
    ├── js/                 # Game logic
    └── index.html          # Standalone entry point
```

---

## ✨ Features Implemented

### 🎨 Premium UI/UX (Glassmorphism)
- **Design System**: Built with **Tailwind CSS** using a custom "Premium" theme.
- **Visuals**: frosted glass cards, neon glows, and smooth animations (`slide-up`, `fade-in`).
- **Responsive**: Mobile-first design with a collapsible navigation menu.

### 🎮 Innovation & Gamification
- **Spinning Wheel**: Integrated the Canvas-based game directly into the main app.
- **AI Chatbot**: Enhanced UI for the Google Gemini-powered assistant.

### 🛠️ Core Functionality
- **Job Matching**: Booking form with "Demo Mode" fallback (works even if PHP backend is down).
- **Internationalization**: English & Malay support.
- **Countdown Timer**: Real-time event countdown.

---

## ❓ Troubleshooting

**Error: `npm error enoent Could not read package.json`**
- **Cause**: You are running `npm install` in the root folder (`The Star`).
- **Fix**: You must `cd job-fair-app` first.

**Error: `[plugin:vite:css] [postcss] ...`**
- **Cause**: Dependency mismatch between Tailwind v3 and v4.
- **Fix**: The project is configured for **Tailwind v3**. Ensure you don't install `@tailwindcss/postcss` (which is for v4). If you see this, run:
  ```bash
  npm uninstall @tailwindcss/postcss
  npm install -D tailwindcss@3 postcss autoprefixer
  ```

---

© 2026 Practical Test Submission
