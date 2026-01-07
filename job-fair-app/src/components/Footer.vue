<template>
  <footer class="bg-dark-900 border-t border-white/10 pt-16 pb-8">
    <div class="container mx-auto px-4">
      <div class="grid md:grid-cols-4 gap-12 mb-12">
        <!-- Brand -->
        <div class="space-y-4">
          <div class="flex items-center gap-2 mb-4">
            <span class="text-2xl">🎯</span>
            <h2 class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-400">
              Job Fair 2026
            </h2>
          </div>
          <p class="text-gray-400 leading-relaxed text-sm">
            {{ $t('footer.desc') }}
          </p>
        </div>
        
        <!-- Quick Links -->
        <div>
          <h4 class="text-white font-bold mb-6">{{ $t('footer.quickLinks') }}</h4>
          <ul class="space-y-3 text-sm text-gray-400">
            <li><a href="#home" class="hover:text-primary transition-colors">{{ $t('footer.links.home') }}</a></li>
            <li><a href="#exhibitors" class="hover:text-primary transition-colors">{{ $t('footer.links.exhibitors') }}</a></li>
            <li><a href="#sessions" class="hover:text-primary transition-colors">{{ $t('footer.links.sessions') }}</a></li>
            <li><a href="#contact" class="hover:text-primary transition-colors">{{ $t('footer.links.contact') }}</a></li>
          </ul>
        </div>
        
        <!-- Contact -->
        <div>
          <h4 class="text-white font-bold mb-6">{{ $t('contact.title') }}</h4>
          <ul class="space-y-3 text-sm text-gray-400">
            <li class="flex items-center gap-2">
              <span>📧</span>
              <a href="mailto:info@jobfair2026.com" class="hover:text-primary transition-colors">info@jobfair2026.com</a>
            </li>
            <li class="flex items-center gap-2">
              <span>📱</span>
              <a href="tel:+1234567890" class="hover:text-primary transition-colors">+60 234 567 890</a>
            </li>
            <li class="flex items-center gap-2">
              <span>📍</span>
              <span>Kuala Lumpur, Malaysia</span>
            </li>
          </ul>
        </div>
        
        <!-- Social -->
        <div>
          <h4 class="text-white font-bold mb-6">{{ $t('footer.followUs') }}</h4>
          <div class="flex gap-4">
            <a href="https://www.facebook.com/TheStarOnline/" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all duration-300 transform hover:scale-110">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
            </a>
            <a href="https://x.com/staronline" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-gray-400 hover:bg-black hover:text-white transition-all duration-300 transform hover:scale-110">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
            <a href="https://www.instagram.com/thestaronline" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-gray-400 hover:bg-pink-600 hover:text-white transition-all duration-300 transform hover:scale-110">
               <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772 4.902 4.902 0 011.772-1.153c.636-.247 1.363-.416 2.427-.465 1.067-.047 1.408-.06 3.808-.06zm0 1.838c-2.202 0-2.474.014-3.559.064-1.04.049-1.758.236-2.408.489-.675.262-1.25.688-1.637 1.076-.388.387-.814.962-1.076 1.637-.253.65-.44 1.368-.489 2.408-.05 1.085-.064 1.357-.064 3.558.064 2.201.014 2.473.064 3.558.049 1.04.236 1.758.489 2.408.262.675.688 1.25 1.076 1.637.387.388.962.814 1.637 1.076.65.253 1.368.44 2.408.489 1.085.05 1.357.064 3.558.064 2.201 0 2.474-.014 3.56-.064 1.04-.049 1.758-.236 2.408-.489.675-.262 1.25-.688 1.637-1.076.387-.388.814-.962 1.076-1.637.253-.65.44-1.368.489-2.408.05-1.084.064-1.356.064-3.559 0-2.202-.014-2.474-.064-3.559-.049-1.04-.236-1.758-.489-2.408a4.902 4.902 0 00-1.076-1.637 4.903 4.903 0 00-1.637-1.076c-.65-.253-1.368-.44-2.408-.489-1.085-.05-1.357-.064-3.559-.064zM12.315 7.152a4.848 4.848 0 110 9.696 4.848 4.848 0 010-9.696zm0 1.838a3.01 3.01 0 100 6.02 3.01 3.01 0 000-6.02z" clip-rule="evenodd" /></svg>
            </a>
          </div>
        </div>
      </div>
      
      <div class="border-t border-white/5 pt-8 text-center">
        <p class="text-gray-500 text-sm">
          &copy; 2026 Job Fair. {{ $t('footer.rights') }}. {{ $t('footer.madeWith') }}.
        </p>
      </div>
    </div>
  </footer>
</template>

<script setup>
</script>

<style scoped>
/* All styles in Tailwind */
</style>
