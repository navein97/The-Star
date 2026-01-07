<template>
  <section id="floor-plan" class="py-24 relative overflow-hidden">
    <!-- Decor -->
    <div class="absolute inset-0 bg-dark-900 -z-10"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-purple-900/20 blur-[120px] rounded-full -z-10"></div>

    <div class="container mx-auto px-4">
      <div class="text-center mb-12 animate-slide-up">
        <h2 class="section-title mb-4">{{ $t('floorPlan.title') }}</h2>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto">{{ $t('floorPlan.subtitle') }}</p>
      </div>
      
      <!-- Search Bar -->
      <div class="max-w-md mx-auto mb-12 relative group z-20">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
          <svg class="h-5 w-5 text-gray-500 group-focus-within:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
        <input
          v-model="searchQuery"
          type="text"
          class="w-full bg-dark-800 border border-white/10 rounded-full pl-12 pr-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all shadow-lg hover:shadow-blue-500/20"
          :placeholder="$t('floorPlan.search')"
        />
      </div>
      
      <!-- Interactive Floor Plan Preview (Thumbnail) -->
      <div class="max-w-4xl mx-auto perspective-1000">
        <div 
          class="relative group cursor-pointer transform transition-all duration-500 hover:scale-[1.02] hover:-rotate-1"
          @click="openModal"
        >
          <!-- Glass Reflection Wrapper -->
          <div class="absolute inset-0 bg-gradient-to-tr from-white/5 to-transparent rounded-2xl z-10 pointer-events-none border border-white/10 shadow-glass-lg"></div>
          
          <!-- Image Container -->
          <div class="bg-dark-800 rounded-2xl overflow-hidden p-2 shadow-2xl">
             <img 
              src="/assets/images/floor-plan.png" 
              alt="Exhibition Floor Plan" 
              class="w-full h-64 md:h-96 object-contain bg-white/5 rounded-xl"
            />
          </div>

          <!-- Overlay (Hover) -->
          <div class="absolute inset-0 flex items-center justify-center bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl z-20">
            <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
              <span class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-bold rounded-full shadow-lg hover:bg-blue-500 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                {{ $t('floorPlan.viewLarger') }}
              </span>
            </div>
          </div>
        </div>
        <p class="text-center text-gray-500 mt-4 text-sm">(Click map to zoom)</p>
      </div>
      
      <!-- Fullscreen Lightbox Modal -->
      <Teleport to="body">
        <div 
          v-if="modalOpen" 
          class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 backdrop-blur-xl animate-fade-in p-4 md:p-8"
          @click="closeModal"
        >
          <!-- Close Button -->
          <button 
            class="absolute top-6 right-6 text-white/50 hover:text-white p-2 transition-colors z-[110]"
            @click="closeModal"
          >
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>

          <!-- Large Image container -->
          <div 
            class="relative w-full h-full flex items-center justify-center" 
            @click.stop
          >
            <img 
              src="/assets/images/floor-plan.png" 
              alt="Large Exhibition Floor Plan" 
              class="max-w-full max-h-full object-contain rounded-lg shadow-2xl cursor-zoom-out"
              @click="closeModal" 
            />
            
            <!-- Helper text -->
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 px-4 py-2 bg-black/50 rounded-full text-white/80 text-sm pointer-events-none">
              Tap anywhere to close
            </div>
          </div>
        </div>
      </Teleport>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const searchQuery = ref('')
const modalOpen = ref(false)

const openModal = () => {
  modalOpen.value = true
  document.body.style.overflow = 'hidden' // Prevent background scrolling
}

const closeModal = () => {
  modalOpen.value = false
  document.body.style.overflow = ''
}
</script>

<style scoped>
.perspective-1000 {
  perspective: 1000px;
}
</style>
