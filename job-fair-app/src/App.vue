<template>
  <div id="app">
    <!-- Header with Language Switcher -->
    <Header @change-language="changeLanguage" :current-language="currentLanguage" />
    
    <!-- Hero Section with Countdown -->
    <Hero />
    
    <!-- Countdown Timer -->
    <CountdownTimer />
    
    <!-- Floor Plan Section -->
    <FloorPlan />
    
    <!-- Exhibitor Section -->
    <ExhibitorSection />
    
    <!-- Job Matching Section -->
    <JobMatching />
    
    <!-- Career Talks Section -->
    <CareerTalks />
    
    <!-- Contact Form -->
    <ContactForm />
    
    <!-- Footer -->
    <Footer />
    
    <!-- Chatbot -->
    <Chatbot />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useI18n } from 'vue-i18n'
import Header from './components/Header.vue'
import Hero from './components/Hero.vue'
import CountdownTimer from './components/CountdownTimer.vue'
import FloorPlan from './components/FloorPlan.vue'
import ExhibitorSection from './components/ExhibitorSection.vue'
import JobMatching from './components/JobMatching.vue'
import CareerTalks from './components/CareerTalks.vue'
import ContactForm from './components/ContactForm.vue'
import Footer from './components/Footer.vue'
import Chatbot from './components/Chatbot.vue'

const { locale } = useI18n()
const currentLanguage = ref(locale.value)

const changeLanguage = (lang) => {
  locale.value = lang
  currentLanguage.value = lang
  localStorage.setItem('language', lang)
}

onMounted(() => {
  // Add scroll animations
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('fade-in')
      }
    })
  }, observerOptions)

  document.querySelectorAll('section').forEach(section => {
    observer.observe(section)
  })
})
</script>

<style scoped>
#app {
  min-height: 100vh;
}
</style>
