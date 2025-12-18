<template>
  <section class="countdown-section">
    <div class="container">
      <h2 class="text-center">{{ $t('countdown.title') }}</h2>
      
      <div class="countdown-grid">
        <div class="countdown-item">
          <div class="countdown-value">{{ days }}</div>
          <div class="countdown-label">{{ $t('countdown.days') }}</div>
        </div>
        
        <div class="countdown-separator">:</div>
        
        <div class="countdown-item">
          <div class="countdown-value">{{ hours }}</div>
          <div class="countdown-label">{{ $t('countdown.hours') }}</div>
        </div>
        
        <div class="countdown-separator">:</div>
        
        <div class="countdown-item">
          <div class="countdown-value">{{ minutes }}</div>
          <div class="countdown-label">{{ $t('countdown.minutes') }}</div>
        </div>
        
        <div class="countdown-separator">:</div>
        
        <div class="countdown-item">
          <div class="countdown-value">{{ seconds }}</div>
          <div class="countdown-label">{{ $t('countdown.seconds') }}</div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const days = ref(0)
const hours = ref(0)
const minutes = ref(0)
const seconds = ref(0)

// Set target date: January 1, 2026
const targetDate = new Date('2026-01-01T09:00:00').getTime()

let intervalId = null

const updateCountdown = () => {
  const now = new Date().getTime()
  const distance = targetDate - now

  if (distance < 0) {
    days.value = 0
    hours.value = 0
    minutes.value = 0
    seconds.value = 0
    if (intervalId) clearInterval(intervalId)
    return
  }

  days.value = Math.floor(distance / (1000 * 60 * 60 * 24))
  hours.value = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
  minutes.value = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))
  seconds.value = Math.floor((distance % (1000 * 60)) / 1000)
}

onMounted(() => {
  updateCountdown()
  intervalId = setInterval(updateCountdown, 1000)
})

onUnmounted(() => {
  if (intervalId) clearInterval(intervalId)
})
</script>

<style scoped>
.countdown-section {
  background: var(--white);
  padding: var(--spacing-2xl) 0;
}

.countdown-grid {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: var(--spacing-lg);
  margin-top: var(--spacing-xl);
}

.countdown-item {
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  color: var(--white);
  padding: var(--spacing-xl);
  border-radius: var(--radius-xl);
  min-width: 120px;
  text-align: center;
  box-shadow: var(--shadow-lg);
  transition: transform var(--transition-base);
}

.countdown-item:hover {
  transform: scale(1.05);
}

.countdown-value {
  font-size: 3rem;
  font-weight: 700;
  font-family: var(--font-display);
  line-height: 1;
  margin-bottom: var(--spacing-sm);
  animation: flipIn 0.6s ease-out;
}

.countdown-label {
  font-size: 0.9rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  opacity: 0.9;
}

.countdown-separator {
  font-size: 3rem;
  font-weight: 700;
  color: var(--primary);
  animation: pulse 2s ease-in-out infinite;
}

@keyframes flipIn {
  from {
    transform: rotateX(90deg);
    opacity: 0;
  }
  to {
    transform: rotateX(0);
    opacity: 1;
  }
}

@media (max-width: 768px) {
  .countdown-grid {
    gap: var(--spacing-sm);
  }
  
  .countdown-item {
    min-width: 80px;
    padding: var(--spacing-md);
  }
  
  .countdown-value {
    font-size: 2rem;
  }
  
  .countdown-label {
    font-size: 0.75rem;
  }
  
  .countdown-separator {
    font-size: 2rem;
  }
}
</style>
