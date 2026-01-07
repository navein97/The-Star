<template>
  <section id="sessions" class="py-24 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute top-[20%] left-[10%] w-64 h-64 bg-cyan-500/20 rounded-full blur-[100px]"></div>
    <div class="absolute bottom-[20%] right-[10%] w-64 h-64 bg-purple-500/20 rounded-full blur-[100px]"></div>

    <div class="container mx-auto px-4 relative z-10">
      <div class="text-center mb-12 animate-slide-up">
        <h2 class="text-4xl md:text-5xl font-display font-bold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500 mb-4">
          {{ $t('jobMatching.title') }}
        </h2>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto">{{ $t('jobMatching.subtitle') }}</p>
      </div>

      <div class="max-w-3xl mx-auto bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8 shadow-glass-lg animate-fade-in">
        <form @submit.prevent="submitForm" class="space-y-6">
          
          <!-- Success/Error Messages -->
          <div v-if="successMessage" class="p-4 bg-green-500/20 border border-green-500/30 rounded-xl flex items-center gap-3 text-green-300">
            <span class="text-2xl">✅</span>
            <span>{{ successMessage }}</span>
          </div>
          <div v-if="errorMessage" class="p-4 bg-red-500/20 border border-red-500/30 rounded-xl flex items-center gap-3 text-red-300">
            <span class="text-2xl">⚠️</span>
            <span>{{ errorMessage }}</span>
          </div>

          <!-- Date & Time Grid -->
          <div class="grid md:grid-cols-2 gap-6">
            <div class="group">
              <label class="block text-sm font-medium text-gray-400 mb-3">{{ $t('jobMatching.selectDate') }} *</label>
              <input 
                v-model="formData.session_date" 
                type="date" 
                class="w-full bg-dark-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none transition-all" 
                :min="minDate"
                @change="fetchAvailableSlots"
                required 
              />
            </div>

            <div class="group">
              <label class="block text-sm font-medium text-gray-400 mb-3">{{ $t('jobMatching.selectTime') }} *</label>
              <div class="relative">
                <select 
                  v-model="formData.session_time" 
                  class="w-full bg-dark-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none transition-all appearance-none cursor-pointer" 
                  required
                >
                  <option value="" class="bg-dark-900 text-gray-500">
                    {{ !formData.session_date ? 'Please select a date first' : (loadingSlots ? 'Checking availability...' : 'Select time slot') }}
                  </option>
                  <option v-for="slot in availableSlots" :key="slot" :value="slot" class="bg-dark-900 text-white">
                    {{ slot }}
                  </option>
                </select>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                  ⬇️
                </div>
              </div>
            </div>
          </div>

          <!-- Personal Details -->
          <div>
            <label class="block text-sm font-medium text-gray-400 mb-3">{{ $t('jobMatching.name') }} *</label>
            <input v-model="formData.name" type="text" class="w-full bg-dark-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none transition-all placeholder-gray-500" placeholder="John Doe" required />
          </div>

          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-400 mb-3">{{ $t('jobMatching.email') }} *</label>
              <input v-model="formData.email" type="email" class="w-full bg-dark-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none transition-all placeholder-gray-500" placeholder="john@example.com" required />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-400 mb-3">{{ $t('jobMatching.phone') }}</label>
              <input v-model="formData.phone" type="tel" class="w-full bg-dark-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none transition-all placeholder-gray-500" placeholder="+60 12-345 6789" />
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-400 mb-3">{{ $t('jobMatching.notes') }}</label>
            <textarea v-model="formData.additional_notes" class="w-full bg-dark-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none transition-all min-h-[100px] placeholder-gray-500" placeholder="Any specific industry interests?"></textarea>
          </div>

          <div class="text-center pt-4">
            <button type="submit" class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 rounded-xl font-bold text-white shadow-lg hover:shadow-cyan-500/25 transform hover:-translate-y-1 transition-all disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none" :disabled="isSubmitting || !formData.session_time">
              <span v-if="isSubmitting" class="flex items-center justify-center gap-2">
                <span class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                Processing...
              </span>
              <span v-else>{{ $t('jobMatching.submit') }}</span>
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
  reservation_type: 'job_matching',
  session_date: '',
  session_time: '',
  additional_notes: ''
})

// Mock slots for "Demo Mode" if backend is unreachable
const mockSlots = ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00']

const fetchAvailableSlots = async () => {
  if (!formData.session_date) return
  
  loadingSlots.value = true
  availableSlots.value = []
  
  try {
    // Try real backend first
    const response = await axios.get(`http://localhost:8000/backend/api/reservation.php`, {
      params: { type: 'slots', date: formData.session_date },
      timeout: 2000 // Short timeout to fallback quickly
    })
    
    if (response.data.success) {
      availableSlots.value = response.data.available_slots
    } else {
      throw new Error("Backend failed")
    }
  } catch (error) {
    // Fallback to Mock Data (Demo Mode)
    console.warn('Backend unavailable, using demo slots')
    // Simulate network delay
    setTimeout(() => {
      availableSlots.value = mockSlots
    }, 500)
  } finally {
    setTimeout(() => { loadingSlots.value = false }, 500)
  }
}

const submitForm = async () => {
  successMessage.value = ''
  errorMessage.value = ''
  isSubmitting.value = true
  
  try {
    const response = await axios.post('http://localhost:8000/backend/api/reservation.php', formData, {
      timeout: 2000
    })
    
    if (response.data.success) {
      handleSuccess(response.data.message)
    } else {
      errorMessage.value = response.data.message
    }
  } catch (error) {
    // Fallback to Mock Success (Demo Mode)
    console.warn('Backend unavailable, using demo success')
    setTimeout(() => {
      handleSuccess("Reservation confirmed! (Demo Mode)")
    }, 1500)
  } finally {
    // Wait for the mock timeout to finish
    if (!errorMessage.value && !successMessage.value) {
       isSubmitting.value = false
    }
  }
}

const handleSuccess = (msg) => {
  successMessage.value = msg
  const type = formData.reservation_type
  Object.keys(formData).forEach(key => formData[key] = '')
  formData.reservation_type = type
  availableSlots.value = []
  isSubmitting.value = false
}
</script>

<style scoped>
/* Scoped styles replaced by Tailwind classes */
</style>
