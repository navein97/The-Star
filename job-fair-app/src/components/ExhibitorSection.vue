<template>
  <section id="exhibitors" class="exhibitor-section">
    <div class="container">
      <div class="section-header text-center">
        <h2>{{ $t('exhibitor.title') }}</h2>
        <p>{{ $t('exhibitor.subtitle') }}</p>
      </div>
      
      <div class="text-center">
        <button @click="openModal" class="btn btn-accent btn-lg">
          {{ $t('exhibitor.button') }}
        </button>
      </div>
      
      <!-- Modal -->
      <div v-if="modalOpen" class="modal-overlay" @click="closeModal">
        <div class="modal-content" @click.stop>
          <div class="modal-header">
            <h3>{{ $t('exhibitor.form.title') }}</h3>
            <button class="modal-close" @click="closeModal">&times;</button>
          </div>
          
          <form @submit.prevent="submitForm">
            <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
            <div v-if="errorMessage" class="alert alert-error">{{ errorMessage }}</div>
            
            <div class="form-group">
              <label class="form-label">{{ $t('exhibitor.form.companyName') }} *</label>
              <input v-model="formData.company_name" type="text" class="form-input" required />
            </div>
            
            <div class="form-group">
              <label class="form-label">{{ $t('exhibitor.form.contactPerson') }} *</label>
              <input v-model="formData.contact_person" type="text" class="form-input" required />
            </div>
            
            <div class="form-group">
              <label class="form-label">{{ $t('exhibitor.form.email') }} *</label>
              <input v-model="formData.email" type="email" class="form-input" required />
            </div>
            
            <div class="form-group">
              <label class="form-label">{{ $t('exhibitor.form.phone') }} *</label>
              <input v-model="formData.phone" type="tel" class="form-input" required />
            </div>
            
            <div class="form-group">
              <label class="form-label">{{ $t('exhibitor.form.industry') }}</label>
              <input v-model="formData.industry" type="text" class="form-input" />
            </div>
            
            <div class="form-group">
              <label class="form-label">{{ $t('exhibitor.form.boothPreference') }}</label>
              <select v-model="formData.booth_preference" class="form-select">
                <option value="">Select preference</option>
                <option value="corner">Corner Booth</option>
                <option value="standard">Standard Booth</option>
                <option value="premium">Premium Booth</option>
              </select>
            </div>
            
            <div class="form-group">
              <label class="form-label">{{ $t('exhibitor.form.additionalInfo') }}</label>
              <textarea v-model="formData.additional_info" class="form-textarea"></textarea>
            </div>
            
            <div class="form-actions">
              <button type="button" @click="closeModal" class="btn btn-secondary">
                {{ $t('exhibitor.form.cancel') }}
              </button>
              <button type="submit" class="btn btn-primary" :disabled="isSubmitting">
                {{ isSubmitting ? $t('messages.loading') : $t('exhibitor.form.submit') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, reactive } from 'vue'
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
.exhibitor-section {
  background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
  color: var(--white);
}

.section-header h2,
.section-header p {
  color: var(--white);
}

.form-actions {
  display: flex;
  gap: var(--spacing-md);
  justify-content: flex-end;
  margin-top: var(--spacing-xl);
}
</style>
