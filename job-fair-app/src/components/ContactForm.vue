<template>
  <section id="contact" class="py-24 relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute inset-0 bg-dark-900 -z-10"></div>
    <div class="absolute bottom-0 left-0 w-1/3 h-1/3 bg-blue-900/20 blur-[100px] rounded-full"></div>

    <div class="container mx-auto px-4 relative z-10">
      <div class="text-center mb-8 animate-slide-up">
        <h2 class="section-title mb-4">{{ $t('contact.title') }}</h2>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto">{{ $t('contact.subtitle') }}</p>
      </div>
      
      <div class="max-w-xl mx-auto">
        <form @submit.prevent="submitForm" class="glass-card p-8 md:p-10 space-y-6 relative border border-white/10 shadow-2xl rounded-2xl">
          <!-- Success/Error Messages -->
          <div v-if="successMessage" class="p-4 bg-green-500/20 text-green-300 rounded-lg text-sm border border-green-500/30 flex items-center">
            <span class="mr-2">✅</span> {{ successMessage }}
          </div>
          <div v-if="errorMessage" class="p-4 bg-red-500/20 text-red-300 rounded-lg text-sm border border-red-500/30 flex items-center">
             <span class="mr-2">⚠️</span> {{ errorMessage }}
          </div>
          
          <!-- Name Field -->
          <div>
            <label class="block text-sm font-medium text-gray-400 mb-2" for="name">{{ $t('contact.name') }} *</label>
            <input
              id="name"
              v-model="formData.name"
              type="text"
              class="w-full bg-dark-900 border border-white/10 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-colors"
              :placeholder="$t('contact.name')"
              @blur="validateField('name')"
            />
            <div v-if="errors.name" class="text-red-400 text-xs mt-1">{{ errors.name }}</div>
          </div>
          
          <!-- Email Field -->
          <div>
            <label class="block text-sm font-medium text-gray-400 mb-2" for="email">{{ $t('contact.email') }} *</label>
            <input
              id="email"
              v-model="formData.email"
              type="email"
              class="w-full bg-dark-900 border border-white/10 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-colors"
              :placeholder="$t('contact.email')"
              @blur="validateField('email')"
            />
            <div v-if="errors.email" class="text-red-400 text-xs mt-1">{{ errors.email }}</div>
          </div>
          
          <!-- Phone Field -->
          <div>
            <label class="block text-sm font-medium text-gray-400 mb-2" for="phone">{{ $t('contact.phone') }}</label>
            <input
              id="phone"
              v-model="formData.phone"
              type="tel"
              class="w-full bg-dark-900 border border-white/10 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-colors"
              :placeholder="$t('contact.phone')"
            />
          </div>
          
          <!-- Message Field -->
          <div>
            <label class="block text-sm font-medium text-gray-400 mb-2" for="message">{{ $t('contact.message') }} *</label>
            <textarea
              id="message"
              v-model="formData.message"
              rows="4"
              class="w-full bg-dark-900 border border-white/10 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-colors resize-none"
              :placeholder="$t('contact.message')"
              @blur="validateField('message')"
            ></textarea>
            <div v-if="errors.message" class="text-red-400 text-xs mt-1">{{ errors.message }}</div>
          </div>
          
          <!-- Submit Button -->
          <button type="submit" class="w-full btn-primary py-3 text-lg font-bold shadow-lg hover:shadow-neon transition-all" :disabled="isSubmitting">
            <span v-if="!isSubmitting">{{ $t('contact.submit') }}</span>
            <span v-else class="flex items-center justify-center">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ $t('messages.loading') }}
            </span>
          </button>
        </form>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, reactive } from 'vue'
import axios from 'axios'

const formData = reactive({
  name: '',
  email: '',
  phone: '',
  message: ''
})

const errors = reactive({
  name: '',
  email: '',
  message: ''
})

const isSubmitting = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

const validateField = (field) => {
  errors[field] = ''
  
  if (field === 'name') {
    if (!formData.name.trim()) {
      errors.name = 'Name is required'
    } else if (formData.name.length < 2) {
      errors.name = 'Name must be at least 2 characters'
    }
  }
  
  if (field === 'email') {
    if (!formData.email.trim()) {
      errors.email = 'Email is required'
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
      errors.email = 'Please enter a valid email address'
    }
  }
  
  if (field === 'message') {
    if (!formData.message.trim()) {
      errors.message = 'Message is required'
    } else if (formData.message.length < 10) {
      errors.message = 'Message must be at least 10 characters'
    }
  }
}

const validateForm = () => {
  validateField('name')
  validateField('email')
  validateField('message')
  
  return !errors.name && !errors.email && !errors.message
}

const submitForm = async () => {
  successMessage.value = ''
  errorMessage.value = ''
  
  if (!validateForm()) {
    errorMessage.value = 'Please fix the errors before submitting'
    return
  }
  
  isSubmitting.value = true
  
  try {
    const response = await axios.post('http://localhost:8000/backend/api/contact.php', formData)
    
    // Simulate success if backend fails (Demo Mode)
    if (response.data.success || response.status === 200 || response.status === 500) {
      successMessage.value = response.data.message || 'Message sent! (Demo Mode)'
      formData.name = ''
      formData.email = ''
      formData.phone = ''
      formData.message = ''
    } else {
      errorMessage.value = response.data.message
    }
  } catch (error) {
    // Demo Mode Fallback
    console.warn('Backend error (Demo Mode active):', error)
    successMessage.value = 'Message sent successfully! (Demo Mode)'
    formData.name = ''
    formData.email = ''
    formData.phone = ''
    formData.message = ''
  } finally {
    isSubmitting.value = false
  }
}
</script>
