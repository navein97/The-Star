<template>
  <div class="w-full bg-dark-800/50 backdrop-blur-sm border-b border-white/5">
    <div class="container mx-auto px-4 py-8">
      <div class="flex flex-col md:flex-row items-center justify-center gap-8 md:gap-16">
        <h3 class="text-xl md:text-2xl font-display font-medium text-gray-300 uppercase tracking-widest">
          Event Starts In
        </h3>
        
        <div class="flex gap-4 md:gap-8">
          <div class="time-block">
            <div class="time-val">{{ days }}</div>
            <div class="time-label">Days</div>
          </div>
          <div class="time-block">
            <div class="time-val">{{ hours }}</div>
            <div class="time-label">Hours</div>
          </div>
          <div class="time-block">
            <div class="time-val">{{ minutes }}</div>
            <div class="time-label">Minutes</div>
          </div>
          <div class="time-block">
            <div class="time-val">{{ seconds }}</div>
            <div class="time-label">Seconds</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const days = ref('00')
const hours = ref('00')
const minutes = ref('00')
const seconds = ref('00')
let interval = null

const targetDate = new Date('2026-03-15T09:00:00').getTime()

const updateTimer = () => {
  const now = new Date().getTime()
  const distance = targetDate - now

  if (distance < 0) {
    clearInterval(interval)
    return
  }

  days.value = Math.floor(distance / (1000 * 60 * 60 * 24)).toString().padStart(2, '0')
  hours.value = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0')
  minutes.value = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0')
  seconds.value = Math.floor((distance % (1000 * 60)) / 1000).toString().padStart(2, '0')
}

onMounted(() => {
  updateTimer()
  interval = setInterval(updateTimer, 1000)
})

onUnmounted(() => {
  if (interval) clearInterval(interval)
})
</script>

<style scoped>
.time-block {
  display: flex;
  flex-direction: column;
  align-items: center;
  background-color: #1E293B;
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 0.75rem;
  padding: 0.75rem;
  min-width: 80px;
  box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
  position: relative;
  overflow: hidden;
}

@media (min-width: 768px) {
  .time-block {
    min-width: 100px;
  }
}

.time-block::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 2px;
  background: linear-gradient(to right, transparent, #2563EB, transparent);
  opacity: 0.5;
}

.time-val {
  font-size: 1.875rem;
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
  font-weight: bold;
  color: white;
  margin-bottom: 0.25rem;
  filter: drop-shadow(0 0 10px rgba(37,99,235,0.5));
}

@media (min-width: 768px) {
  .time-val {
    font-size: 3rem;
  }
}

.time-label {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  color: #6b7280;
  font-weight: 500;
}
</style>
