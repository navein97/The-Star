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
          <p>Click to view larger floor plan</p>
          <p class="view-text">{{ $t('floorPlan.viewLarger') }} 🔍</p>
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
            <p>Large floor plan view</p>
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
  background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
  border-radius: var(--radius-xl);
  padding: var(--spacing-3xl);
  text-align: center;
  min-height: 400px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  border: 2px dashed var(--gray-400);
}

.view-text {
  font-size: 1.25rem;
  font-weight: 600;
  color: var(--primary);
  margin-top: var(--spacing-md);
}

.floor-plan-large {
  background: var(--gray-100);
  min-height: 600px;
  border-radius: var(--radius-lg);
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
