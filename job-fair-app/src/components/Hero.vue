<template>
  <section id="home" class="relative min-h-[90vh] flex items-center pt-20 pb-24 overflow-hidden bg-gradient-to-br from-indigo-900 via-purple-900 to-dark-bg text-white">
    <!-- Animated Background Effect -->
    <div class="absolute inset-0 z-0">
      <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-blue-600/30 rounded-full blur-[100px] animate-pulse"></div>
      <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-purple-600/30 rounded-full blur-[100px] animate-pulse delay-1000"></div>
      <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgb3BhY2l0eT0iMC4xIj48Y2lyY2xlIGN4PSIyIiBjeT0iMiIgcj0iMiIgZmlsbD0id2hpdGUiLz48L3N2Zz4=')] opacity-30"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <!-- Text Content -->
        <div class="space-y-6 animate-slide-up">
          <div class="inline-block px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 text-sm font-semibold tracking-wider uppercase text-cyan-300 mb-4">
            🚀 {{ $t('hero.tagline') }}
          </div>
          
          <h1 class="text-5xl md:text-7xl font-display font-bold leading-tight">
            {{ $t('hero.title') }}
          </h1>
          
          <p class="text-xl text-gray-300 leading-relaxed max-w-lg">
            {{ $t('hero.subtitle') }}
          </p>
          
          <div class="flex flex-col sm:flex-row gap-6 pt-4 text-gray-200">
            <div class="flex items-center gap-3 bg-white/5 px-4 py-2 rounded-lg border border-white/10">
              <span class="text-2xl">📅</span>
              <span class="font-medium">{{ $t('hero.date') }}</span>
            </div>
            <div class="flex items-center gap-3 bg-white/5 px-4 py-2 rounded-lg border border-white/10">
              <span class="text-2xl">📍</span>
              <span class="font-medium">{{ $t('hero.location') }}</span>
            </div>
          </div>
          
          <div class="pt-8 flex flex-col sm:flex-row gap-4">
            <button class="btn-primary text-lg px-8">
              {{ $t('hero.cta') }}
            </button>
            <button class="btn-outline text-lg px-8 group">
              {{ $t('hero.schedule') }}
              <span class="inline-block ml-2 group-hover:translate-x-1 transition-transform">→</span>
            </button>
          </div>
        </div>
        
        <!-- Hero Image / Visual -->
        <div class="relative h-[400px] md:h-[500px] flex items-center justify-center animate-fade-in delay-200">
          <div class="relative w-full h-full">
            <img src="/assets/images/hero.png" alt="Job Fair" class="w-full h-full object-cover rounded-3xl shadow-2xl border-4 border-white/10 mask-image" />
            
            <!-- Floating Stats Cards -->
            <div class="absolute top-[10%] -left-[5%] bg-dark-800/80 backdrop-blur-md p-4 rounded-xl border border-white/10 shadow-xl animate-float">
              <div class="text-3xl font-bold text-accent">1000+</div>
              <div class="text-sm text-gray-400">{{ $t('hero.stat_jobs') }}</div>
            </div>
            
            <div class="absolute bottom-[20%] -right-[5%] bg-dark-800/80 backdrop-blur-md p-4 rounded-xl border border-white/10 shadow-xl animate-float [animation-delay:1.5s]">
              <div class="text-3xl font-bold text-purple-400">200+</div>
              <div class="text-sm text-gray-400">{{ $t('hero.stat_companies') }}</div>
            </div>
            
            <div class="absolute top-[50%] right-[10%] bg-dark-800/80 backdrop-blur-md p-3 rounded-xl border border-white/10 shadow-xl animate-float [animation-delay:0.8s] scale-90">
              <div class="text-xl font-bold text-green-400">50+</div>
              <div class="text-xs text-gray-400">{{ $t('hero.stat_talks') }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.mask-image {
  mask-image: linear-gradient(to bottom, black 80%, transparent 100%);
}
</style>
