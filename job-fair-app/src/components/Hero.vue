<template>
  <section id="home" class="hero">
    <div class="container">
      <div class="hero-content">
        <div class="hero-text">
          <h1 class="hero-title">{{ $t('hero.title') }}</h1>
          <p class="hero-subtitle">{{ $t('hero.subtitle') }}</p>
          
          <div class="hero-details">
            <div class="detail-item">
              <span class="icon">📅</span>
              <span>{{ $t('hero.date') }}</span>
            </div>
            <div class="detail-item">
              <span class="icon">📍</span>
              <span>{{ $t('hero.location') }}</span>
            </div>
          </div>
          
          <button class="btn btn-primary btn-lg">
            {{ $t('hero.cta') }}
          </button>
        </div>
        
        <div class="hero-image">
          <img src="/assets/images/hero.png" alt="Job Fair Illustration" class="hero-img" />
          <div class="floating-stats">
            <div class="floating-card">
              <h3>1000+</h3>
              <p>Job Opportunities</p>
            </div>
            <div class="floating-card">
              <h3>200+</h3>
              <p>Companies</p>
            </div>
            <div class="floating-card">
              <h3>50+</h3>
              <p>Career Talks</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.hero {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: var(--white);
  padding: var(--spacing-3xl) 0;
  position: relative;
  overflow: hidden;
}

.hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/></svg>');
  opacity: 0.3;
}

.hero-content {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: var(--spacing-3xl);
  align-items: center;
  position: relative;
  z-index: 1;
}

.hero-title {
  color: var(--white);
  margin-bottom: var(--spacing-lg);
  animation: slideUp 0.8s ease-out;
}

.hero-subtitle {
  font-size: 1.25rem;
  color: rgba(255, 255, 255, 0.9);
  margin-bottom: var(--spacing-xl);
  animation: slideUp 0.8s ease-out 0.2s both;
}

.hero-details {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-md);
  margin-bottom: var(--spacing-xl);
  animation: slideUp 0.8s ease-out 0.4s both;
}

.detail-item {
  display: flex;
  align-items: center;
  gap: var(--spacing-md);
  font-size: 1.1rem;
  color: rgba(255, 255, 255, 0.95);
}

.icon {
  font-size: 1.5rem;
}

.btn-lg {
  padding: var(--spacing-md) var(--spacing-2xl);
  font-size: 1.1rem;
  animation: slideUp 0.8s ease-out 0.6s both;
}

.hero-image {
  position: relative;
  height: 400px;
}

.hero-img {
  width: 100%;
  height: auto;
  border-radius: var(--radius-2xl);
  box-shadow: var(--shadow-2xl);
  animation: fadeIn 1s ease-out;
}

.floating-stats {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

.floating-card {
  position: absolute;
  background: rgba(30, 41, 59, 0.9);
  backdrop-filter: blur(8px);
  color: var(--white);
  padding: var(--spacing-md) var(--spacing-lg);
  border-radius: var(--radius-xl);
  box-shadow: var(--shadow-xl);
  text-align: center;
  animation: float 3s ease-in-out infinite;
  pointer-events: auto;
  min-width: 140px;
  border: 1px solid rgba(255, 255, 255, 0.1);
}

.floating-card h3 {
  color: #60a5fa;
  margin: 0;
  font-size: 1.5rem;
}

.floating-card p {
  margin: 0;
  font-size: 0.8rem;
  opacity: 0.8;
}

/* Spread cards out to avoid blocking */
.floating-card:nth-child(1) {
  top: 15%;
  left: -10%;
}

.floating-card:nth-child(2) {
  top: -5%;
  right: 35%;
  animation-delay: 0.5s;
}

.floating-card:nth-child(3) {
  bottom: 30%;
  right: -3%;
  animation-delay: 1s;
}

.floating-card p {
  color: var(--gray-600);
  margin: 0;
  font-size: 0.9rem;
}

@keyframes float {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-20px);
  }
}

@media (max-width: 768px) {
  .hero-content {
    grid-template-columns: 1fr;
  }
  
  .hero-image {
    height: 300px;
  }
  
  .floating-card {
    padding: var(--spacing-md);
  }
  
  .floating-card h3 {
    font-size: 1.5rem;
  }
}
</style>
