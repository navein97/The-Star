import { createApp } from 'vue'
import { createI18n } from 'vue-i18n'
import App from './App.vue'
import './assets/base.css'

// Import translation files
import en from './locales/en.json'
import ms from './locales/ms.json'

// Create I18n instance
const i18n = createI18n({
  legacy: false,
  locale: localStorage.getItem('language') || 'en',
  fallbackLocale: 'en',
  messages: {
    en: en.en,
    ms: ms.ms
  }
})

// Create and mount app
const app = createApp(App)
app.use(i18n)
app.mount('#app')
