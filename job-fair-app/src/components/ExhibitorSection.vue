<template>
  <section id="exhibitors" class="py-24 relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute inset-0 bg-dark-900 -z-10"></div>
    <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-purple-900/20 to-transparent"></div>
    
    <div class="container mx-auto px-4 relative z-10">
      <div class="text-center mb-16 animate-slide-up">
        <h2 class="text-4xl md:text-5xl font-display font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-purple-400 mb-4">
          {{ $t('exhibitor.title') }}
        </h2>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto">{{ $t('exhibitor.subtitle') }}</p>
      </div>
      
      <div class="text-center">
        <button @click="openModal" class="btn-primary text-xl px-12 py-4 shadow-neon group">
          {{ $t('exhibitor.button') }}
          <span class="inline-block ml-2 group-hover:-translate-y-1 transition-transform">✨</span>
        </button>
      </div>
      
      <!-- Modal -->
      <Teleport to="body">
        <div v-if="modalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
          <!-- Backdrop -->
          <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="closeModal"></div>
          
          <!-- Modal Content -->
          <div class="relative w-full max-w-md bg-dark-800 border border-white/10 rounded-2xl shadow-2xl overflow-hidden animate-fade-in" @click.stop>
            <!-- Header -->
            <div class="bg-gradient-to-r from-pink-600 to-purple-600 p-6 flex items-center justify-between">
              <h3 class="text-xl font-bold text-white">{{ $t('exhibitor.form.title') }}</h3>
              <button class="text-white/80 hover:text-white text-2xl" @click="closeModal">&times;</button>
            </div>
            
            <div class="p-8">
              <form @submit.prevent="submitForm" class="space-y-4">
                <div v-if="successMessage" class="p-3 bg-green-500/20 text-green-300 rounded-lg text-sm border border-green-500/30">
                  {{ successMessage }}
                </div>
                <div v-if="errorMessage" class="p-3 bg-red-500/20 text-red-300 rounded-lg text-sm border border-red-500/30">
                  {{ errorMessage }}
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-400 mb-1">{{ $t('exhibitor.form.companyName') }} *</label>
                  <input v-model="formData.company_name" type="text" class="w-full bg-dark-900 border border-white/10 rounded-lg px-4 py-3 text-white focus:border-pink-500 outline-none transition-colors" required />
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">{{ $t('exhibitor.form.contactPerson') }} *</label>
                    <input v-model="formData.contact_person" type="text" class="w-full bg-dark-900 border border-white/10 rounded-lg px-4 py-3 text-white focus:border-pink-500 outline-none transition-colors" required />
                  </div>
                   <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">{{ $t('exhibitor.form.industry') }}</label>
                    <input v-model="formData.industry" type="text" class="w-full bg-dark-900 border border-white/10 rounded-lg px-4 py-3 text-white focus:border-pink-500 outline-none transition-colors" />
                  </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">{{ $t('exhibitor.form.email') }} *</label>
                    <input v-model="formData.email" type="email" class="w-full bg-dark-900 border border-white/10 rounded-lg px-4 py-3 text-white focus:border-pink-500 outline-none transition-colors" required />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">{{ $t('exhibitor.form.phone') }} *</label>
                    <input v-model="formData.phone" type="tel" class="w-full bg-dark-900 border border-white/10 rounded-lg px-4 py-3 text-white focus:border-pink-500 outline-none transition-colors" required />
                  </div>
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-400 mb-1">{{ $t('exhibitor.form.boothPreference') }}</label>
                  <select v-model="formData.booth_preference" class="w-full bg-dark-900 border border-white/10 rounded-lg px-4 py-3 text-white focus:border-pink-500 outline-none transition-colors appearance-none">
                    <option value="">Select preference</option>
                    <option value="corner">Corner Booth</option>
                    <option value="standard">Standard Booth</option>
                    <option value="premium">Premium Booth</option>
                  </select>
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-400 mb-1">{{ $t('exhibitor.form.additionalInfo') }}</label>
                  <textarea v-model="formData.additional_info" class="w-full bg-dark-900 border border-white/10 rounded-lg px-4 py-3 text-white focus:border-pink-500 outline-none transition-colors min-h-[100px]"></textarea>
                </div>
                
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/10 mt-6">
                  <button type="button" @click="closeModal" class="px-6 py-2 rounded-lg text-gray-400 hover:text-white font-medium transition-colors">
                    {{ $t('exhibitor.form.cancel') }}
                  </button>
                  <button type="submit" class="px-8 py-2 bg-gradient-to-r from-pink-600 to-purple-600 rounded-lg text-white font-bold shadow-lg hover:shadow-neon hover:scale-105 transition-all disabled:opacity-50 disabled:cursor-not-allowed" :disabled="isSubmitting">
                    {{ isSubmitting ? $t('messages.loading') : $t('exhibitor.form.submit') }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </Teleport>
    </div>
  </section>
</template>

<script setup>
import { ref, reactive } from 'vue'
// Remove axios dependency if not installed, but it was in package.json
import axios from 'axios'

const modalOpen = ref(false)
const isSubmitting = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

const formData = reactive({
  company_name: '',
  contact_person: '',
  email: '',
  phone: '',
  industry: '',
  booth_preference: '',
  additional_info: ''
})

const openModal = () => {
  modalOpen.value = true
  document.body.style.overflow = 'hidden'
}

const closeModal = () => {
  modalOpen.value = false
  document.body.style.overflow = ''
}

const submitForm = async () => {
  successMessage.value = ''
  errorMessage.value = ''
  isSubmitting.value = true
  
  try {
    const response = await axios.post('http://localhost:8000/backend/api/exhibitor.php', formData)
    
    if (response.data.success) {
      successMessage.value = response.data.message
      Object.keys(formData).forEach(key => formData[key] = '')
      setTimeout(() => closeModal(), 2000)
    } else {
      errorMessage.value = response.data.message
    }
  } catch (error) {
    errorMessage.value = 'An error occurred. Please try again.'
  } finally {
    isSubmitting.value = false
  }
}
</script>

<style scoped>
/* No styles needed - all Tailwind! */
</style>
