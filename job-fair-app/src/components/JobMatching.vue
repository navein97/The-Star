<template>
  <section id="sessions" class="job-matching-section">
    <div class="container">
      <div class="section-header text-center">
        <h2>{{ $t('jobMatching.title') }}</h2>
        <p>{{ $t('jobMatching.subtitle') }}</p>
      </div>

      <div class="reservation-card">
        <form @submit.prevent="submitForm">
          <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
          <div v-if="errorMessage" class="alert alert-error">{{ errorMessage }}</div>

          <div class="grid grid-2">
            <!-- Date Selection -->
            <div class="form-group">
              <label class="form-label">{{ $t('jobMatching.selectDate') }} *</label>
              <input 
                v-model="formData.session_date" 
                type="date" 
                class="form-input" 
                :min="minDate"
                @change="fetchAvailableSlots"
                required 
              />
            </div>

            <!-- Time Selection -->
            <div class="form-group">
              <label class="form-label">{{ $t('jobMatching.selectTime') }} *</label>
              <select 
                v-model="formData.session_time" 
                class="form-select" 
                :disabled="!formData.session_date || loadingSlots"
                required
              >
                <option value="">{{ loadingSlots ? 'Loading...' : 'Select time slot' }}</option>
                <option v-for="slot in availableSlots" :key="slot" :value="slot">
                  {{ slot }}
                </option>
              </select>
              <div v-if="availableSlots.length === 0 && formData.session_date && !loadingSlots" class="form-error">
                {{ $t('jobMatching.noSlots') }}
              </div>
            </div>
          </div>

          <!-- Personal Details -->
          <div class="form-group">
            <label class="form-label">{{ $t('jobMatching.name') }} *</label>
            <input v-model="formData.name" type="text" class="form-input" required />
          </div>

          <div class="grid grid-2">
            <div class="form-group">
              <label class="form-label">{{ $t('jobMatching.email') }} *</label>
              <input v-model="formData.email" type="email" class="form-input" required />
            </div>

            <div class="form-group">
              <label class="form-label">{{ $t('jobMatching.phone') }}</label>
              <input v-model="formData.phone" type="tel" class="form-input" />
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">{{ $t('jobMatching.notes') }}</label>
            <textarea v-model="formData.additional_notes" class="form-textarea"></textarea>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary" :disabled="isSubmitting || !formData.session_time">
              {{ isSubmitting ? $t('messages.loading') : $t('jobMatching.submit') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import axios from 'axios'

const isSubmitting = ref(false)
const loadingSlots = ref(false)
const successMessage = ref('')
const errorMessage = ref('')
const availableSlots = ref([])

const minDate = new Date().toISOString().split('T')[0]

const formData = reactive({
  name: '',
  email: '',
  phone: '',
  reservation_type: 'job_matching',
  session_date: '',
  session_time: '',
  additional_notes: ''
})

const fetchAvailableSlots = async () => {
  if (!formData.session_date) return
  
  loadingSlots.value = true
  availableSlots.value = []
  
  try {
    const response = await axios.get(`http://localhost:8000/backend/api/reservation.php`, {
      params: {
        type: 'slots',
        date: formData.session_date
      }
    })
    
    if (response.data.success) {
      let slots = response.data.available_slots
      
      // If the selected date is today, filter out past time slots
      if (formData.session_date === minDate) {
        const now = new Date()
        const currentHour = now.getHours()
        const currentMinute = now.getMinutes()
        
        slots = slots.filter(slot => {
          const [slotHour, slotMinute] = slot.split(':').map(Number)
          if (slotHour > currentHour) return true
          if (slotHour === currentHour && slotMinute > currentMinute) return true
          return false
        })
      }
      
      availableSlots.value = slots
    }
  } catch (error) {
    console.error('Error fetching slots:', error)
  } finally {
    loadingSlots.value = false
  }
}

const submitForm = async () => {
  successMessage.value = ''
  errorMessage.value = ''
  isSubmitting.value = true
  
  try {
    const response = await axios.post('http://localhost:8000/backend/api/reservation.php', formData)
    
    if (response.data.success) {
      successMessage.value = response.data.message
      // Reset form but keep type
      const type = formData.reservation_type
      Object.keys(formData).forEach(key => formData[key] = '')
      formData.reservation_type = type
      availableSlots.value = []
    } else {
      errorMessage.value = response.data.message
    }
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'An error occurred. Please try again.'
  } finally {
    isSubmitting.value = false
  }
}
</script>

<style scoped>
.job-matching-section {
  background: var(--white);
}

.reservation-card {
  max-width: 800px;
  margin: 0 auto;
  background: var(--white);
  padding: var(--spacing-xl);
  border-radius: var(--radius-xl);
  box-shadow: var(--shadow-lg);
  border: 1px solid var(--gray-200);
}
</style>
