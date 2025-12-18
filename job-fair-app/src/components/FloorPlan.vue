<template>
  <section id="floor-plan" class="floor-plan-section">
    <div class="container">
      <div class="section-header text-center">
        <h2>{{ $t('floorPlan.title') }}</h2>
        <p>{{ $t('floorPlan.subtitle') }}</p>
      </div>
      
      <div class="search-bar">
        <input
          v-model="searchQuery"
          type="text"
          class="form-input"
          :placeholder="$t('floorPlan.search')"
        />
      </div>
      
      <div class="floor-plan-container" @click="openModal">
        <div class="floor-plan-preview">
          <img src="/assets/images/floor-plan.png" alt="Exhibition Floor Plan" class="floor-map-img" />
          <div class="overlay-text">
            <span>{{ $t('floorPlan.viewLarger') }} 🔍</span>
          </div>
        </div>
      </div>
      
      <!-- Modal -->
      <div v-if="modalOpen" class="modal-overlay" @click="closeModal">
        <div class="modal-content" @click.stop>
          <div class="modal-header">
            <h3>Floor Plan</h3>
            <button class="modal-close" @click="closeModal">&times;</button>
          </div>
          <div class="floor-plan-large">
            <img src="/assets/images/floor-plan.png" alt="Large Exhibition Floor Plan" />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const searchQuery = ref('')
const modalOpen = ref(false)

const openModal = () => {
  modalOpen.value = true
  document.body.style.overflow = 'hidden'
}

const closeModal = () => {
  modalOpen.value = false
  document.body.style.overflow = ''
}
</script>

<style scoped>
.floor-plan-section {
  background: var(--white);
}

.section-header {
  margin-bottom: var(--spacing-xl);
}

.search-bar {
  max-width: 500px;
  margin: 0 auto var(--spacing-xl);
}

.floor-plan-container {
  cursor: pointer;
  transition: transform var(--transition-base);
}

.floor-plan-container:hover {
  transform: scale(1.02);
}

.floor-plan-preview {
  position: relative;
  border-radius: var(--radius-xl);
  overflow: hidden;
  box-shadow: var(--shadow-lg);
  aspect-ratio: 16 / 9;
}

.floor-map-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform var(--transition-slow);
}

.floor-plan-container:hover .floor-map-img {
  transform: scale(1.1);
}

.overlay-text {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(37, 99, 235, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity var(--transition-base);
}

.floor-plan-container:hover .overlay-text {
  opacity: 1;
}

.overlay-text span {
  color: var(--white);
  font-size: 1.5rem;
  font-weight: 700;
  background: rgba(0, 0, 0, 0.5);
  padding: var(--spacing-sm) var(--spacing-lg);
  border-radius: var(--radius-md);
}

.floor-plan-large {
  width: 100%;
}

.floor-plan-large img {
  width: 100%;
  height: auto;
  border-radius: var(--radius-md);
}
</style>
