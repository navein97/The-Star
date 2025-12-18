# Front-End Developer Practical Test Solution

This repository contains the completed code for the "Job Fair Web Application" and "Spinning Wheel Game" practical test assignments.

## 📂 Project Structure

```
/
├── job-fair-app/           # Assignment #1: Vue.js Web Application
│   ├── src/                # Vue source code
│   ├── backend/            # PHP API endpoints
│   ├── database/           # SQL schema
│   └── ...
└── spinning-wheel-game/    # Assignment #2: HTML5 Canvas Game
    ├── data/               # Prize configuration JSON
    ├── js/                 # Game logic
    └── ...
```

---

## 🚀 Assignment #1: Job Fair Web Application

A single-page application built with **Vue 3** and **PHP**, featuring interactive elements, real-time forms, and multi-language support.

### Features
- **Interactive Floor Plan**: Searchable exhibitor directory with lightbox view.
- **Reservations**: Book "Job Matching" and "Career Talk" sessions with real-time slot availability.
- **Forms**: Validation for contact and exhibitor registration forms.
- **Chatbot**: Simulated AI assistant for FAQs (ready for OpenAI integration).
- **Internationalization**: Full English & Malay (Bahasa Malaysia) support.
- **Countdown Timer**: Live countdown to the event start.

### Setup Instructions

1. **Prerequisites**:
   - Node.js (v16+)
   - PHP (v8.0+)
   - MySQL

2. **Database Setup**:
   - Create a new MySQL database named `job_fair_db`.
   - Import the schema from `job-fair-app/database/schema.sql`.
   - Update `job-fair-app/backend/config/database.php` with your database credentials.

3. **Backend Setup**:
   - Start the PHP built-in server:
     ```bash
     cd job-fair-app
     php -S localhost:8000
     ```

4. **Frontend Setup**:
   - Open a new terminal.
   - Install dependencies and start the dev server:
     ```bash
     cd job-fair-app
     npm install
     npm run dev
     ```
   - Access the app at `http://localhost:3000`.

---

## 🎰 Assignment #2: Spinning Wheel Game

A browser-based game using **HTML5 Canvas** for rendering and **JavaScript** for logic.

### Features
- **Configurable Prizes**: Edit `data/prizes.json` to change prizes, probabilities, and visuals.
- **Realistic Physics**: Smooth ease-out animation for spinning.
- **Probability Logic**: Outcomes are weighted based on configuration.
- **Winning Effects**: Confetti and animations for huge wins.

### Setup Instructions

1. Simply open `spinning-wheel-game/index.html` in any modern web browser.
2. **Note**: Due to browser security policies (CORS) regarding fetching local JSON files, you might need to run it via a local server. You can use the same PHP server or a python server:
   ```bash
   cd spinning-wheel-game
   python -m http.server 8080
   # Open http://localhost:8080
   ```

---

## 📝 Notes
- The **Chatbot** in Assignment #1 is currently using simulated responses. To use a real AI, uncomment the API call in `Chatbot.vue` and add your OpenAI API key.
- **Responsive Design**: Both projects are fully responsive and mobile-friendly.

---

© 2025 Practical Test Submission
