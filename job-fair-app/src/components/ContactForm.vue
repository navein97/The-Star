<template>
  <section id="contact" class="contact-section">
    <div class="container">
      <div class="section-header text-center">
        <h2>{{ $t('contact.title') }}</h2>
        <p>{{ $t('contact.subtitle') }}</p>
      </div>
      
      <div class="contact-form-wrapper">
        <form @submit.prevent="submitForm" class="contact-form">
          <!-- Success/Error Messages -->
          <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
          </div>
          <div v-if="errorMessage" class="alert alert-error">
            {{ errorMessage }}
          </div>
          
          <!-- Name Field -->
          <div class="form-group">
            <label class="form-label" for="name">{{ $t('contact.name') }} *</label>
            <input
              id="name"
              v-model="formData.name"
              type="text"
              class="form-input"
              :placeholder="$t('contact.name')"
              @blur="validateField('name')"
            />
            <div v-if="errors.name" class="form-error">{{ errors.name }}</div>
          </div>
          
          <!-- Email Field -->
          <div class="form-group">
            <label class="form-label" for="email">{{ $t('contact.email') }} *</label>
            <input
              id="email"
              v-model="formData.email"
              type="email"
              class="form-input"
              :placeholder="$t('contact.email')"
              @blur="validateField('email')"
            />
            <div v-if="errors.email" class="form-error">{{ errors.email }}</div>
          </div>
          
          <!-- Phone Field -->
          <div class="form-group">
            <label class="form-label" for="phone">{{ $t('contact.phone') }}</label>
            <input
              id="phone"
              v-model="formData.phone"
              type="tel"
              class="form-input"
              :placeholder="$t('contact.phone')"
            />
          </div>
          
          <!-- Message Field -->
          <div class="form-group">
            <label class="form-label" for="message">{{ $t('contact.message') }} *</label>
            <textarea
              id="message"
              v-model="formData.message"
              class="form-textarea"
              :placeholder="$t('contact.message')"
              @blur="validateField('message')"
            ></textarea>
            <div v-if="errors.message" class="form-error">{{ errors.message }}</div>
          </div>
          
          <!-- Submit Button -->
          <button type="submit" class="btn btn-primary" :disabled="isSubmitting">
            <span v-if="!isSubmitting">{{ $t('contact.submit') }}</span>
            <span v-else>
              <span class="spinner"></span>
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
    
    if (response.data.success) {
      successMessage.value = response.data.message
      // Reset form
      formData.name = ''
      formData.email = ''
      formData.phone = ''
      formData.message = ''
    } else {
      errorMessage.value = response.data.message
    }
  } catch (error) {
    console.error('Contact form error:', error)
    errorMessage.value = 'An error occurred. Please try again later.'
  } finally {
    isSubmitting.value = false
  }
}
</script>

<style scoped>
.contact-section {
  background: var(--gray-50);
}

.section-header {
  margin-bottom: var(--spacing-3xl);
}

.section-header p {
  font-size: 1.25rem;
  color: var(--gray-600);
}

.contact-form-wrapper {
  max-width: 600px;
  margin: 0 auto;
}

.contact-form {
  background: var(--white);
  padding: var(--spacing-2xl);
  border-radius: var(--radius-2xl);
  box-shadow: var(--shadow-lg);
}

.btn[type="submit"] {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: var(--spacing-sm);
}

.spinner {
  display: inline-block;
  width: 16px;
  height: 16px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-top-color: white;
  border-radius: 50%;
  animation: spin 0.6s linear infinite;
}
</style>
