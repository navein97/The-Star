<template>
  <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
    <!-- Chat Window -->
    <transition name="slide-up">
      <div v-show="isOpen" class="mb-4 w-[350px] md:w-[400px] h-[500px] bg-white/90 backdrop-blur-xl border border-white/40 rounded-2xl shadow-glass-lg flex flex-col overflow-hidden animate-fade-in">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary to-secondary p-4 flex items-center justify-between text-white shadow-md">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
              🤖
            </div>
            <div>
              <h3 class="font-bold text-sm md:text-base">{{ $t('chatbot.title') }}</h3>
              <span class="flex items-center gap-1.5 text-xs text-blue-100">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                Online
              </span>
            </div>
          </div>
          <button @click="toggleChat" class="text-white/80 hover:text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        
        <!-- Messages Area -->
        <div class="flex-1 p-4 overflow-y-auto space-y-4 bg-gray-50/50" ref="messagesContainer">
          <div v-for="(msg, index) in messages" :key="index" 
               :class="['flex w-full', msg.type === 'user' ? 'justify-end' : 'justify-start']">
            <div :class="[
              'max-w-[80%] p-3 rounded-2xl text-sm leading-relaxed shadow-sm',
              msg.type === 'user' 
                ? 'bg-primary text-white rounded-br-none' 
                : 'bg-white border border-gray-100 text-gray-800 rounded-bl-none'
            ]">
              {{ msg.text }}
            </div>
          </div>
          
          <!-- Typing Indicator -->
          <div v-if="isTyping" class="flex justify-start w-full">
            <div class="bg-white border border-gray-100 p-3 rounded-2xl rounded-bl-none shadow-sm flex items-center gap-1">
              <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce [animation-delay:-0.3s]"></div>
              <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce [animation-delay:-0.15s]"></div>
              <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
            </div>
          </div>
        </div>
        
        <!-- Input Area -->
        <div class="p-4 bg-white border-t border-gray-100">
          <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-full px-4 py-2 focus-within:ring-2 focus-within:ring-primary/20 transition-shadow">
            <input 
              v-model="inputMessage" 
              @keyup.enter="sendMessage"
              :placeholder="$t('chatbot.placeholder')"
              type="text"
              class="flex-1 bg-transparent border-none outline-none text-sm text-gray-700 placeholder-gray-400"
            />
            <button 
              @click="sendMessage" 
              :disabled="!inputMessage.trim()"
              class="p-2 bg-primary text-white rounded-full hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors shadow-sm"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </transition>

    <!-- Toggle Button -->
    <button 
      @click="toggleChat"
      :class="['w-16 h-16 rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95',
               isOpen ? 'bg-gray-700 rotate-90 opacity-0 pointer-events-none absolute' : 'bg-gradient-to-r from-primary to-secondary rotate-0 opacity-100']"
    >
      <span class="text-3xl">💬</span>
      
      <!-- Notification Badge -->
      <span class="absolute top-0 right-0 flex h-4 w-4">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500"></span>
      </span>
    </button>
  </div>
</template>

<script setup>
import { ref, nextTick, watch } from 'vue'

const isOpen = ref(false)
const inputMessage = ref('')
const messages = ref([
  { type: 'bot', text: 'Hi there! 👋 I\'m your AI Job Fair Assistant. Ask me anything about exhibitors, schedules, or career tips!' }
])
const isTyping = ref(false)
const messagesContainer = ref(null)

const toggleChat = () => {
  isOpen.value = !isOpen.value
  if (isOpen.value) {
    scrollToBottom()
  }
}

const scrollToBottom = () => {
  nextTick(() => {
    if (messagesContainer.value) {
      messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight
    }
  })
}

const sendMessage = async () => {
  if (!inputMessage.value.trim()) return
  
  const userText = inputMessage.value
  messages.value.push({ type: 'user', text: userText })
  inputMessage.value = ''
  scrollToBottom()
  
  isTyping.value = true
  
  // Simulated AI delay for effect
  setTimeout(async () => {
    try {
      // NOTE: Using localhost backend as per original code. 
      // Ensure backend/api/chatbot.php is running.
      const response = await fetch('http://localhost:8000/backend/api/chatbot.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ message: userText })
      })
      
      const data = await response.json()
      
      if (data.success) {
        messages.value.push({ type: 'bot', text: data.reply })
      } else {
        // Fallback for demo if backend fails
        messages.value.push({ type: 'bot', text: "I'm currently in demo mode. The backend connection seems to be offline, but I'm here to help!" })
      }
      
    } catch (error) {
      console.error('Chatbot error:', error)
      messages.value.push({ type: 'bot', text: "I seem to be having trouble reaching the server. Please try again later." })
    } finally {
      isTyping.value = false
      scrollToBottom()
    }
  }, 1000)
}
</script>

<style scoped>
/* No styles needed - all Tailwind! */
</style>
