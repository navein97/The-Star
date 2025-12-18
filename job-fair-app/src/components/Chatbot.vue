<template>
  <div class="chatbot-container" :class="{ open: isOpen }">
    <!-- Chat Toggle Button -->
    <button class="chat-toggle" @click="toggleChat">
      <span v-if="!isOpen">💬</span>
      <span v-else>&times;</span>
    </button>
    
    <!-- Chat Window -->
    <div class="chat-window" v-show="isOpen">
      <div class="chat-header">
        <h3>{{ $t('chatbot.title') }}</h3>
      </div>
      
      <div class="chat-messages" ref="messagesContainer">
        <div v-for="(msg, index) in messages" :key="index" class="message" :class="msg.type">
          <div class="message-content">{{ msg.text }}</div>
        </div>
        <div v-if="isTyping" class="message bot">
          <div class="typing-indicator">
            <span></span><span></span><span></span>
          </div>
        </div>
      </div>
      
      <div class="chat-input-area">
        <input 
          v-model="inputMessage" 
          @keyup.enter="sendMessage"
          :placeholder="$t('chatbot.placeholder')"
          type="text" 
        />
        <button @click="sendMessage" :disabled="!inputMessage.trim()">
          {{ $t('chatbot.send') }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, nextTick, watch } from 'vue'

const isOpen = ref(false)
const inputMessage = ref('')
const messages = ref([
  { type: 'bot', text: 'Hi! How can I help you with the Job Fair today?' }
])
const isTyping = ref(false)
const messagesContainer = ref(null)

const toggleChat = () => {
  isOpen.value = !isOpen.value
  if (isOpen.value) scrollToBottom()
}

const scrollToBottom = () => {
  nextTick(() => {
    if (messagesContainer.value) {
      messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight
    }
  })
}

// NOTE: In a real production app, you should call your own backend
// which then calls OpenAI, to protect your API key.
// For this demo, we'll simulate a response or use a placeholder API call.
const sendMessage = async () => {
  if (!inputMessage.value.trim()) return
  
  const userText = inputMessage.value
  messages.value.push({ type: 'user', text: userText })
  inputMessage.value = ''
  scrollToBottom()
  
  isTyping.value = true
  
  try {
    // Simulate API delay
    await new Promise(resolve => setTimeout(resolve, 1000))
    
    // Simple rule-based responses for demo purposes (since we don't have a real API key)
    let botResponse = "I'm not sure about that. Please contact our support team."
    
    const lowerText = userText.toLowerCase()
    if (lowerText.includes('location') || lowerText.includes('where')) {
      botResponse = "The Job Fair is held at Kuala Lumpur Convention Centre."
    } else if (lowerText.includes('time') || lowerText.includes('when')) {
      botResponse = "The event is on October 15-16, 2025, from 9:00 AM to 6:00 PM."
    } else if (lowerText.includes('register') || lowerText.includes('sign up')) {
      botResponse = "You can register as an exhibitor using the 'Be Our Exhibitor' button above."
    } else if (lowerText.includes('job') || lowerText.includes('matching')) {
      botResponse = "You can book job matching sessions in the 'Job Matching Sessions' section."
    }
    
    messages.value.push({ type: 'bot', text: botResponse })
    scrollToBottom()
  } catch (error) {
    messages.value.push({ type: 'bot', text: "Sorry, I'm having trouble connecting right now." })
  } finally {
    isTyping.value = false
    scrollToBottom()
  }
}
</script>

<style scoped>
.chatbot-container {
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 1000;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.chat-toggle {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: var(--primary);
  color: var(--white);
  border: none;
  font-size: 24px;
  cursor: pointer;
  box-shadow: var(--shadow-lg);
  transition: transform 0.3s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.chat-toggle:hover {
  transform: scale(1.1);
}

.chat-window {
  position: absolute;
  bottom: 80px;
  right: 0;
  width: 350px;
  height: 500px;
  background: var(--white);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-2xl);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  animation: slideUp 0.3s ease-out;
}

.chat-header {
  background: var(--primary);
  color: var(--white);
  padding: var(--spacing-md);
}

.chat-header h3 {
  margin: 0;
  font-size: 1.1rem;
}

.chat-messages {
  flex: 1;
  padding: var(--spacing-md);
  overflow-y: auto;
  display: flex;
  flex-direction: column;
  gap: var(--spacing-sm);
  background: var(--gray-50);
}

.message {
  max-width: 80%;
  padding: var(--spacing-sm) var(--spacing-md);
  border-radius: var(--radius-lg);
  font-size: 0.95rem;
  line-height: 1.4;
}

.message.user {
  align-self: flex-end;
  background: var(--primary);
  color: var(--white);
  border-bottom-right-radius: 2px;
}

.message.bot {
  align-self: flex-start;
  background: var(--white);
  color: var(--gray-800);
  box-shadow: var(--shadow-sm);
  border-bottom-left-radius: 2px;
}

.chat-input-area {
  padding: var(--spacing-md);
  border-top: 1px solid var(--gray-200);
  display: flex;
  gap: var(--spacing-sm);
  background: var(--white);
}

.chat-input-area input {
  flex: 1;
  padding: var(--spacing-sm);
  border: 1px solid var(--gray-300);
  border-radius: var(--radius-md);
  outline: none;
}

.chat-input-area input:focus {
  border-color: var(--primary);
}

.chat-input-area button {
  background: var(--primary);
  color: var(--white);
  border: none;
  padding: var(--spacing-sm) var(--spacing-md);
  border-radius: var(--radius-md);
  cursor: pointer;
  font-weight: 600;
}

.chat-input-area button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.typing-indicator {
  display: flex;
  gap: 4px;
  padding: 4px;
}

.typing-indicator span {
  width: 6px;
  height: 6px;
  background: var(--gray-400);
  border-radius: 50%;
  animation: bounce 1.4s infinite ease-in-out;
}

.typing-indicator span:nth-child(1) { animation-delay: -0.32s; }
.typing-indicator span:nth-child(2) { animation-delay: -0.16s; }

@keyframes bounce {
  0%, 80%, 100% { transform: scale(0); }
  40% { transform: scale(1); }
}

@media (max-width: 480px) {
  .chat-window {
    width: calc(100vw - 40px);
    height: 60vh;
  }
}
</style>
