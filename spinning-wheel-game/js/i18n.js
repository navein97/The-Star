const translations = {
    en: {
        gameTitle: "Spin & Win!",
        spinBtn: "SPIN!",
        claimBtn: "Claim Prize",
        wonMessage: "You won:",
        noPrizes: "No more prizes available!",
        congrats: "Congratulations!",
        tryAgain: "Try Again",
        loading: "Loading..."
    },
    ms: {
        gameTitle: "Putar & Menang!",
        spinBtn: "PUTAR!",
        claimBtn: "Tuntut Hadiah",
        wonMessage: "Anda menang:",
        noPrizes: "Tiada lagi hadiah tersedia!",
        congrats: "Tahniah!",
        tryAgain: "Cuba Lagi",
        loading: "Memuatkan..."
    }
};

let currentLang = 'en';

function t(key) {
    return translations[currentLang][key] || key;
}

function switchLanguage(lang) {
    if (!translations[lang]) return;
    currentLang = lang;
    updateUIText();
}

function updateUIText() {
    document.getElementById('spinBtn').textContent = t('spinBtn');
    document.getElementById('claimBtn').textContent = t('claimBtn');
    document.getElementById('modalTitle').textContent = t('congrats');
    // Title is set dynamically from JSON, but we could map it if needed
    // For this test, we'll keep the JSON title as primary but update UI elements
}
