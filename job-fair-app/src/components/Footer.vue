<template>
  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-info">
          <h3>Job Fair 2025</h3>
          <p>{{ $t('footer.organizer') }}</p>
        </div>
        
        <div class="footer-links">
          <a href="#" class="social-link">Facebook</a>
          <a href="#" class="social-link">Twitter</a>
          <a href="#" class="social-link">LinkedIn</a>
          <a href="#" class="social-link">Instagram</a>
        </div>
        
        <div class="footer-copyright">
          <p>&copy; 2025 Star Media Group Berhad. {{ $t('footer.rights') }}</p>
        </div>
      </div>
    </div>
  </footer>
</template>

<style scoped>
.footer {
  background: var(--gray-900);
  color: var(--white);
  padding: var(--spacing-2xl) 0;
  margin-top: auto;
}

.footer-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: var(--spacing-xl);
  text-align: center;
}

.footer-info h3 {
  color: var(--white);
  margin-bottom: var(--spacing-xs);
}

.footer-info p {
  color: var(--gray-400);
  margin: 0;
}

.footer-links {
  display: flex;
  gap: var(--spacing-lg);
  flex-wrap: wrap;
  justify-content: center;
}

.social-link {
  color: var(--gray-300);
  font-weight: 500;
  transition: color var(--transition-fast);
}

.social-link:hover {
  color: var(--white);
}

.footer-copyright {
  border-top: 1px solid var(--gray-800);
  padding-top: var(--spacing-lg);
  width: 100%;
}

.footer-copyright p {
  color: var(--gray-500);
  font-size: 0.9rem;
  margin: 0;
}
</style>
