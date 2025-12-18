<template>
  <section class="career-talks-section">
    <div class="container">
      <div class="section-header text-center">
        <h2>{{ $t('careerTalk.title') }}</h2>
        <p>{{ $t('careerTalk.subtitle') }}</p>
      </div>

      <div class="reservation-card">
        <!-- Reusing similar structure to Job Matching but with specific styling -->
        <form @submit.prevent="submitForm">
          <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
          <div v-if="errorMessage" class="alert alert-error">{{ errorMessage }}</div>

          <div class="grid grid-2">
            <div class="form-group">
              <label class="form-label">{{ $t('careerTalk.selectDate') }} *</label>
              <input 
                v-model="formData.session_date" 
                type="date" 
                class="form-input"
                :min="minDate"
                @change="fetchAvailableSlots" 
                required 
              />
            </div>

            <div class="form-group">
              <label class="form-label">{{ $t('careerTalk.selectTime') }} *</label>
              <select 
                v-model="formData.session_time" 
                class="form-select"
                :disabled="!formData.session_date || loadingSlots"
                required
              >
                <option value="">{{ loadingSlots ? 'Loading...' : 'Select session' }}</option>
                <option v-for="slot in availableSlots" :key="slot" :value="slot">
                  {{ slot }}
                </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">{{ $t('careerTalk.name') }} *</label>
            <input v-model="formData.name" type="text" class="form-input" required />
          </div>

          <div class="grid grid-2">
            <div class="form-group">
              <label class="form-label">{{ $t('careerTalk.email') }} *</label>
              <input v-model="formData.email" type="email" class="form-input" required />
            </div>

            <div class="form-group">
              <label class="form-label">{{ $t('careerTalk.phone') }}</label>
              <input v-model="formData.phone" type="tel" class="form-input" />
            </div>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-accent" :disabled="isSubmitting || !formData.session_time">
              {{ isSubmitting ? $t('messages.loading') : $t('careerTalk.submit') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, reactive } from 'vue'
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
  reservation_type: 'career_talk',
  session_date: '',
  session_time: '',
  additional_notes: ''
})

const fetchAvailableSlots = async () => {
  if (!formData.session_date) return
  loadingSlots.value = true
  
  try {
    const response = await axios.get(`http://localhost:8000/backend/api/reservation.php`, {
      params: { type: 'slots', date: formData.session_date }
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
    console.error('Error fetching slots', error)
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
      const type = formData.reservation_type
      Object.keys(formData).forEach(key => formData[key] = '')
      formData.reservation_type = type
      availableSlots.value = []
    } else {
      errorMessage.value = response.data.message
    }
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Error processing request'
  } finally {
    isSubmitting.value = false
  }
}
</script>

<style scoped>
.career-talks-section {
  background: var(--gray-50);
}

.reservation-card {
  max-width: 800px;
  margin: 0 auto;
  background: var(--white);
  padding: var(--spacing-xl);
  border-radius: var(--radius-xl);
  box-shadow: var(--shadow-lg);
}
</style>
