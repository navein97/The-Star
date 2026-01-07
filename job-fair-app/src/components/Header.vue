<template>
  <header class="fixed top-0 w-full z-50 transition-all duration-300 bg-white/10 backdrop-blur-md border-b border-white/20 shadow-glass-sm">
    <div class="container mx-auto px-4 md:px-6">
      <div class="flex items-center justify-between py-4">
        <!-- Logo -->
        <div class="flex items-center gap-2">
          <span class="text-2xl">🎯</span>
          <h2 class="text-2xl font-display font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">
            Job Fair 2026
          </h2>
        </div>
        
        <!-- Desktop Nav -->
        <nav class="hidden md:flex items-center gap-8">
          <a href="#home" class="nav-link">{{ $t('hero.title') }}</a>
          <a href="#exhibitors" class="nav-link">{{ $t('exhibitor.title') }}</a>
          <a href="#sessions" class="nav-link">Sessions</a>
          <a href="#contact" class="nav-link">{{ $t('contact.title') }}</a>
        </nav>
        
        <!-- Right Side Actions -->
        <div class="flex items-center gap-4">
          <!-- Language Switcher -->
          <div class="hidden md:flex items-center bg-white/20 backdrop-blur-sm rounded-lg p-1 border border-white/30">
            <button 
              @click="$emit('change-language', 'en')"
              :class="['px-3 py-1 rounded-md text-sm font-semibold transition-all duration-300', 
                       currentLanguage === 'en' ? 'bg-white text-primary shadow-sm' : 'text-gray-600 hover:text-primary']"
            >
              EN
            </button>
            <button 
              @click="$emit('change-language', 'ms')"
              :class="['px-3 py-1 rounded-md text-sm font-semibold transition-all duration-300', 
                       currentLanguage === 'ms' ? 'bg-white text-primary shadow-sm' : 'text-gray-600 hover:text-primary']"
            >
              MS
            </button>
          </div>

          <!-- Mobile Menu Button -->
          <button class="md:hidden p-2 text-gray-700 hover:text-primary transition-colors" @click="toggleMobileMenu">
            <div class="space-y-1.5 w-6">
              <span class="block w-full h-0.5 bg-current transition-all" :class="{ 'rotate-45 translate-y-2': mobileMenuOpen }"></span>
              <span class="block w-full h-0.5 bg-current transition-all" :class="{ 'opacity-0': mobileMenuOpen }"></span>
              <span class="block w-full h-0.5 bg-current transition-all" :class="{ '-rotate-45 -translate-y-2': mobileMenuOpen }"></span>
            </div>
          </button>
        </div>
      </div>
      
      <!-- Mobile Menu -->
      <div 
        class="md:hidden overflow-hidden transition-all duration-300 ease-in-out border-t border-white/10"
        :class="mobileMenuOpen ? 'max-h-96 opacity-100 py-4' : 'max-h-0 opacity-0'"
      >
        <div class="flex flex-col gap-4">
          <a href="#home" class="mobile-nav-link" @click="toggleMobileMenu">{{ $t('hero.title') }}</a>
          <a href="#exhibitors" class="mobile-nav-link" @click="toggleMobileMenu">{{ $t('exhibitor.title') }}</a>
          <a href="#sessions" class="mobile-nav-link" @click="toggleMobileMenu">Sessions</a>
          <a href="#contact" class="mobile-nav-link" @click="toggleMobileMenu">{{ $t('contact.title') }}</a>
          
          <!-- Mobile Language Switcher -->
          <div class="flex items-center gap-4 pt-4 border-t border-gray-200/50">
            <span class="text-sm font-medium text-gray-500">Language:</span>
            <button 
              @click="$emit('change-language', 'en')"
              :class="['font-semibold', currentLanguage === 'en' ? 'text-primary' : 'text-gray-500']"
            >
              English
            </button>
            <button 
              @click="$emit('change-language', 'ms')"
              :class="['font-semibold', currentLanguage === 'ms' ? 'text-primary' : 'text-gray-500']"
            >
              Malay
            </button>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'

defineProps({
  currentLanguage: String
})

defineEmits(['change-language'])

const mobileMenuOpen = ref(false)

const toggleMobileMenu = () => {
  mobileMenuOpen.value = !mobileMenuOpen.value
}
</script>

<style scoped>
.nav-link {
  @apply font-semibold text-gray-700 hover:text-primary transition-colors relative;
}

.nav-link::after {
  content: '';
  @apply absolute -bottom-1 left-0 w-0 h-0.5 bg-primary transition-all duration-300;
}

.nav-link:hover::after {
  @apply w-full;
}

.mobile-nav-link {
  @apply text-lg font-medium text-gray-800 hover:text-primary hover:pl-2 transition-all block;
}
</style>
