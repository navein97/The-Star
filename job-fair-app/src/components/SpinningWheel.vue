<template>
  <section id="spin-win" class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-dark-bg to-indigo-900/50 -z-10"></div>
    
    <div class="container mx-auto px-4 text-center relative z-10">
      <h2 class="section-title mb-4">🎡 {{ $t('spinWheel.title') }}</h2>
      <p class="text-gray-300 mb-12 max-w-2xl mx-auto text-lg">
        {{ $t('spinWheel.subtitle') }}
      </p>

      <div class="flex flex-col items-center gap-8">
        <div class="relative group">
          <!-- Glass Container for Wheel -->
          <div class="relative p-4 bg-white/5 backdrop-blur-md rounded-full border-4 border-white/10 shadow-glass-lg transition-transform duration-500 hover:scale-105">
            <!-- Pointer -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-6 z-20">
              <div class="w-12 h-16 bg-gradient-to-b from-red-500 to-red-700 clip-arrow shadow-lg"></div>
            </div>
            
            <canvas 
              ref="canvas" 
              width="500" 
              height="500"
              class="w-full max-w-[350px] md:max-w-[500px] h-auto rounded-full cursor-pointer"
              @click="spinWheel"
            ></canvas>
          </div>
          
          <!-- Spin Button -->
          <div class="mt-8">
            <button 
              @click="spinWheel" 
              :disabled="isSpinning"
              class="btn-primary text-xl px-12 py-4 shadow-neon disabled:opacity-50 disabled:cursor-not-allowed"
            >
              {{ isSpinning ? $t('spinWheel.spinning') : $t('spinWheel.button') }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Result Modal -->
    <Teleport to="body">
      <div v-if="showModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="closeModal"></div>
        <div class="bg-dark-800 border border-white/10 rounded-2xl p-8 max-w-md w-full relative z-10 text-center animate-fade-in shadow-2xl">
          <h3 class="text-3xl font-display font-bold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500 mb-4">
            {{ $t('spinWheel.won') }}
          </h3>
          <p class="text-xl text-white mb-2">{{ $t('spinWheel.youWon') }}</p>
          <p class="text-2xl font-bold text-accent mb-8 p-4 bg-white/5 rounded-xl border border-white/10">
            {{ wonPrize?.label }}
          </p>
          <button @click="closeModal" class="btn-primary w-full">
            {{ $t('spinWheel.claim') }}
          </button>
        </div>
      </div>
    </Teleport>
  </section>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import confetti from 'canvas-confetti'

const canvas = ref(null)
const isSpinning = ref(false)
const showModal = ref(false)
const wonPrize = ref(null)
const currentRotation = ref(0)
let ctx = null

// Prizes Configuration
const prizes = [
  { id: 1, label: "MacBook Pro", color: "#FFD700", textColor: "#000000", probability: 0.05 },
  { id: 2, label: "iPhone 15", color: "#C0C0C0", textColor: "#000000", probability: 0.10 },
  { id: 3, label: "iPad Air", color: "#CD7F32", textColor: "#000000", probability: 0.15 },
  { id: 4, label: "Starbucks Card", color: "#4CAF50", textColor: "#FFFFFF", probability: 0.30 },
  { id: 5, label: "Notebook", color: "#2196F3", textColor: "#FFFFFF", probability: 0.20 },
  { id: 6, label: "No Luck", color: "#F44336", textColor: "#FFFFFF", probability: 0.20 }
]

const drawWheel = () => {
  if (!canvas.value) return
  const width = canvas.value.width
  const height = canvas.value.height
  const centerX = width / 2
  const centerY = height / 2
  const radius = width / 2 - 10
  const sliceAngle = (2 * Math.PI) / prizes.length

  ctx.clearRect(0, 0, width, height)
  
  // Save context for rotation
  ctx.save()
  ctx.translate(centerX, centerY)
  ctx.rotate(currentRotation.value)
  ctx.translate(-centerX, -centerY)

  prizes.forEach((prize, index) => {
    const startAngle = index * sliceAngle
    const endAngle = startAngle + sliceAngle

    // Draw Slice
    ctx.beginPath()
    ctx.moveTo(centerX, centerY)
    ctx.arc(centerX, centerY, radius, startAngle, endAngle)
    ctx.closePath()
    ctx.fillStyle = prize.color
    ctx.fill()
    ctx.lineWidth = 2
    ctx.strokeStyle = '#ffffff'
    ctx.stroke()

    // Draw Text
    ctx.save()
    ctx.translate(centerX, centerY)
    ctx.rotate(startAngle + sliceAngle / 2)
    ctx.textAlign = "right"
    ctx.fillStyle = prize.textColor
    ctx.font = "bold 20px Inter, sans-serif"
    ctx.fillText(prize.label, radius - 40, 6)
    ctx.restore()
  })

  // Center Circle (Decoration)
  ctx.beginPath()
  ctx.arc(centerX, centerY, 40, 0, 2 * Math.PI)
  ctx.fillStyle = '#ffffff'
  ctx.fill()
  
  // Center Pin
  ctx.beginPath()
  ctx.arc(centerX, centerY, 10, 0, 2 * Math.PI)
  ctx.fillStyle = '#2563EB'
  ctx.fill()

  ctx.restore()
}

const spinWheel = () => {
  if (isSpinning.value) return
  
  isSpinning.value = true
  
  // Determine winner based on probability
  const rand = Math.random()
  let cumulativeProbability = 0
  let selectedPrize = prizes[prizes.length - 1]

  for (const prize of prizes) {
    cumulativeProbability += prize.probability
    if (rand <= cumulativeProbability) {
      selectedPrize = prize
      break
    }
  }

  const prizeIndex = prizes.findIndex(p => p.id === selectedPrize.id)
  
  // Calculation Logic
  // 0 degrees is at 3 o'clock. Pointer is at 12 o'clock (-PI/2)
  // We need to rotate so the target slice *centers* at 12 o'clock
  const sliceAngle = (2 * Math.PI) / prizes.length
  
  // We want the MIDDLE of the slice to align with -PI/2 (top)
  // Current position of middle of slice 'prizeIndex' in the array is: prizeIndex * sliceAngle + sliceAngle/2
  // We need to add rotation 'R' such that: (prizeIndex * sliceAngle + sliceAngle/2) + R = -PI/2 (plus multiple of 2PI)
  
  // Work backwards:
  // Target visual angle is -PI/2 (270 deg or -90 deg).
  // The slice starts at angle 0 in the "wheel space".
  // So we need to rotate the "wheel space" so the specific slice hits the top.
  
  const extraSpins = 5 // Always do 5 full spins for consistency
  // The angle where the prize CENTER is currently (if rotation was 0)
  const currentPrizeAngle = prizeIndex * sliceAngle + sliceAngle / 2
  
  // We want to rotate backwards to bring that angle to -PI/2
  // Target Rotation = -PI/2 - currentPrizeAngle
  // Add positive spins: Target = -PI/2 - currentPrizeAngle + (Spins * 2PI)
  
  const targetRotation = (-Math.PI / 2) - currentPrizeAngle + (extraSpins * 2 * Math.PI) 
  
  // Reset rotation to within 0-2PI to avoid huge numbers over time if we kept adding? 
  // Actually fine to just animate from 0 (or current) to Target.
  
  const startRotation = currentRotation.value % (2 * Math.PI) // Reset visualization start
  const finalRotation = targetRotation
  
  const duration = 4000
  const startTime = performance.now()

  const animate = (currentTime) => {
    const elapsed = currentTime - startTime
    const progress = Math.min(elapsed / duration, 1)
    
    // Ease Out Quart
    const ease = 1 - Math.pow(1 - progress, 4)
    
    currentRotation.value = startRotation + (finalRotation - startRotation) * ease
    drawWheel()

    if (progress < 1) {
      requestAnimationFrame(animate)
    } else {
      isSpinning.value = false
      wonPrize.value = selectedPrize
      showModal.value = true
      launchConfetti()
    }
  }

  requestAnimationFrame(animate)
}

const launchConfetti = () => {
  confetti({
    particleCount: 150,
    spread: 70,
    origin: { y: 0.6 },
    colors: ['#2563EB', '#7C3AED', '#06B6D4', '#ffffff']
  })
}

const closeModal = () => {
  showModal.value = false
}

onMounted(() => {
  if (canvas.value) {
    ctx = canvas.value.getContext('2d')
    drawWheel()
  }
})
</script>

<style scoped>
.clip-arrow {
  clip-path: polygon(100% 0, 0 0, 50% 100%);
}
</style>
