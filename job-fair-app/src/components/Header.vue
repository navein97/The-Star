<template>
  <header class="header">
    <div class="container">
      <div class="header-content">
        <div class="logo">
          <h2>🎯 Job Fair 2026</h2>
        </div>
        
        <nav class="nav">
          <a href="#home" class="nav-link">{{ $t('hero.title') }}</a>
          <a href="#exhibitors" class="nav-link">{{ $t('exhibitor.title') }}</a>
          <a href="#sessions" class="nav-link">Sessions</a>
          <a href="#contact" class="nav-link">{{ $t('contact.title') }}</a>
        </nav>
        
        <div class="language-switcher">
          <button 
            @click="$emit('change-language', 'en')"
            :class="['lang-btn', { active: currentLanguage === 'en' }]"
          >
            EN
          </button>
          <button 
            @click="$emit('change-language', 'ms')"
            :class="['lang-btn', { active: currentLanguage === 'ms' }]"
          >
            MS
          </button>
        </div>
        
        <button class="mobile-menu-btn" @click="toggleMobileMenu">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
      
      <!-- Mobile Menu -->
      <div v-if="mobileMenuOpen" class="mobile-menu">
        <a href="#home" class="mobile-nav-link" @click="toggleMobileMenu">{{ $t('hero.title') }}</a>
        <a href="#exhibitors" class="mobile-nav-link" @click="toggleMobileMenu">{{ $t('exhibitor.title') }}</a>
        <a href="#sessions" class="mobile-nav-link" @click="toggleMobileMenu">Sessions</a>
        <a href="#contact" class="mobile-nav-link" @click="toggleMobileMenu">{{ $t('contact.title') }}</a>
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
.header {
  position: sticky;
  top: 0;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  box-shadow: var(--shadow-md);
  z-index: 100;
  padding: var(--spacing-md) 0;
}

.header-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: var(--spacing-lg);
}

.logo h2 {
  margin: 0;
  color: var(--primary);
  font-size: 1.5rem;
}

.nav {
  display: flex;
  gap: var(--spacing-xl);
  align-items: center;
}

.nav-link {
  font-weight: 600;
  color: var(--gray-700);
  transition: color var(--transition-fast);
  position: relative;
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: -4px;
  left: 0;
  width: 0;
  height: 2px;
  background: var(--primary);
  transition: width var(--transition-base);
}

.nav-link:hover {
  color: var(--primary);
}

.nav-link:hover::after {
  width: 100%;
}

.language-switcher {
  display: flex;
  gap: var(--spacing-xs);
  background: var(--gray-100);
  padding: 4px;
  border-radius: var(--radius-lg);
}

.lang-btn {
  padding: var(--spacing-xs) var(--spacing-md);
  border: none;
  background: transparent;
  color: var(--gray-600);
  font-weight: 600;
  border-radius: var(--radius-md);
  cursor: pointer;
  transition: all var(--transition-fast);
}

.lang-btn.active {
  background: var(--white);
  color: var(--primary);
  box-shadow: var(--shadow-sm);
}

.lang-btn:hover:not(.active) {
  color: var(--primary);
}

.mobile-menu-btn {
  display: none;
  flex-direction: column;
  gap: 4px;
  background: none;
  border: none;
  cursor: pointer;
  padding: var(--spacing-xs);
}

.mobile-menu-btn span {
  width: 24px;
  height: 3px;
  background: var(--gray-700);
  border-radius: 2px;
  transition: all var(--transition-base);
}

.mobile-menu {
  display: none;
  flex-direction: column;
  gap: var(--spacing-md);
  padding: var(--spacing-lg) 0;
  animation: slideDown var(--transition-base);
}

.mobile-nav-link {
  font-weight: 600;
  color: var(--gray-700);
  padding: var(--spacing-sm) 0;
  border-bottom: 1px solid var(--gray-200);
}

@media (max-width: 768px) {
  .nav {
    display: none;
  }
  
  .mobile-menu-btn {
    display: flex;
  }
  
  .mobile-menu {
    display: flex;
  }
  
  .language-switcher {
    order: -1;
  }
}
</style>
