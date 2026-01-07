<template>
  <section id="career-talks" class="py-24 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 bg-dark-900 -z-10"></div>
    <div class="absolute top-[30%] right-[15%] w-72 h-72 bg-emerald-500/20 rounded-full blur-[100px]"></div>

    <div class="container mx-auto px-4 relative z-10">
      <div class="text-center mb-12 animate-slide-up">
        <h2 class="section-title mb-4 bg-clip-text text-transparent bg-gradient-to-r from-emerald-400 to-teal-500">
          {{ $t('careerTalk.title') }}
        </h2>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto">{{ $t('careerTalk.subtitle') }}</p>
      </div>

      <div class="max-w-3xl mx-auto bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8 shadow-glass-lg animate-fade-in">
        <form @submit.prevent="submitForm" class="space-y-6">
          <div v-if="successMessage" class="p-4 bg-green-500/20 text-green-300 rounded-lg flex items-center gap-2">
            ✅ {{ successMessage }}
          </div>
          <div v-if="errorMessage" class="p-4 bg-red-500/20 text-red-300 rounded-lg flex items-center gap-2">
            ⚠️ {{ errorMessage }}
          </div>

          <div class="grid md:grid-cols-2 gap-6">
            <div class="group">
              <label class="block text-sm font-medium text-gray-400 mb-2">{{ $t('careerTalk.selectDate') }} *</label>
              <input 
                v-model="formData.session_date" 
                type="date" 
                class="w-full bg-dark-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition-all placeholder-gray-500"
                :min="minDate"
                @change="fetchAvailableSlots" 
                required 
              />
            </div>

            <div class="group">
              <label class="block text-sm font-medium text-gray-400 mb-2">{{ $t('careerTalk.selectTime') }} *</label>
              <div class="relative">
                <select 
                  v-model="formData.session_time" 
                  class="w-full bg-dark-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition-all appearance-none cursor-pointer"
                  required
                >
                  <option value="" class="bg-dark-900 text-gray-400">
                    {{ !formData.session_date ? 'Please select a date first' : (loadingSlots ? 'Loading...' : 'Select session') }}
                  </option>
                  <option v-for="slot in availableSlots" :key="slot" :value="slot" class="bg-dark-900 text-white">
                    {{ slot }}
                  </option>
                </select>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">⬇️</div>
              </div>
            </div>
          </div>

          <div class="group">
            <label class="block text-sm font-medium text-gray-400 mb-2">{{ $t('careerTalk.name') }} *</label>
            <input v-model="formData.name" type="text" class="w-full bg-dark-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition-all placeholder-gray-500" required />
          </div>

          <div class="grid md:grid-cols-2 gap-6">
            <div class="group">
              <label class="block text-sm font-medium text-gray-400 mb-2">{{ $t('careerTalk.email') }} *</label>
              <input v-model="formData.email" type="email" class="w-full bg-dark-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition-all placeholder-gray-500" required />
            </div>

            <div class="group">
              <label class="block text-sm font-medium text-gray-400 mb-2">{{ $t('careerTalk.phone') }}</label>
              <input v-model="formData.phone" type="tel" class="w-full bg-dark-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition-all placeholder-gray-500" />
            </div>
          </div>

          <div class="text-center pt-6">
            <button type="submit" class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 rounded-xl font-bold text-white shadow-lg transform hover:-translate-y-1 transition-all disabled:opacity-70 disabled:cursor-not-allowed" :disabled="isSubmitting || !formData.session_time">
              <span v-if="isSubmitting" class="flex items-center justify-center gap-2">
                <span class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                Processing...
              </span>
              <span v-else>{{ $t('careerTalk.submit') }}</span>
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
      params: { type: 'slots', date: formData.session_date },
      timeout: 2000
    })
    if (response.data.success) {
      let slots = response.data.available_slots
      // Filter logic if needed
      availableSlots.value = slots
    } else {
      // Mock for demo
      throw new Error('Backend failed')
    }
  } catch (error) {
    console.warn('Backend unavailable, using demo slots')
    setTimeout(() => { availableSlots.value = ['10:00', '12:00', '14:00', '16:00'] }, 500)
  } finally {
    setTimeout(() => { loadingSlots.value = false }, 500)
  }
}

const submitForm = async () => {
  successMessage.value = ''
  errorMessage.value = ''
  isSubmitting.value = true
  
  try {
    const response = await axios.post('http://localhost:8000/backend/api/reservation.php', formData, { timeout: 2000 })
    if (response.data.success) {
      handleSuccess(response.data.message)
    } else {
      errorMessage.value = response.data.message
    }
  } catch (error) {
    console.warn('Backend unavailable, using demo success')
    setTimeout(() => { handleSuccess("Registration confirmed! (Demo Mode)") }, 1500)
  } finally {
    if (!errorMessage.value && !successMessage.value) isSubmitting.value = false
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
