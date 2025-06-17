<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <router-link to="/" class="flex items-center font-bold text-xl text-gray-900">
              Merchant Notes
            </router-link>
          </div>
          <div class="flex items-center space-x-4">
            <router-link
              to="/"
              class="px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900"
              :class="{ 'text-blue-600 font-semibold': $route.name === 'merchants' }"
            >
              Merchants
            </router-link>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <router-view />
    </main>

    <!-- Loading Overlay -->
    <div
      v-if="loading"
      class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center"
    >
      <div class="bg-white p-6 rounded-lg shadow-lg text-center">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
        <p class="mt-2 text-gray-600">Loading...</p>
      </div>
    </div>

    <!-- Toast Notifications -->
    <div class="fixed top-4 right-4 z-40">
      <div
        v-for="toast in toasts"
        :key="toast.id"
        class="mb-2 p-4 rounded-lg shadow-lg max-w-sm transition-all duration-300"
        :class="{
          'bg-green-500 text-white': toast.type === 'success',
          'bg-red-500 text-white': toast.type === 'error',
          'bg-blue-500 text-white': toast.type === 'info'
        }"
      >
        <div class="flex justify-between items-center">
          <span>{{ toast.message }}</span>
          <button
            @click="removeToast(toast.id)"
            class="ml-2 text-white hover:text-gray-200 font-bold"
          >
            ×
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      loading: false,
      toasts: []
    }
  },
  methods: {
    showToast(message, type = 'info') {
      const id = Date.now()
      this.toasts.push({ id, message, type })
      setTimeout(() => this.removeToast(id), 5000)
    },
    removeToast(id) {
      this.toasts = this.toasts.filter(toast => toast.id !== id)
    }
  },
  provide() {
    return {
      showToast: this.showToast,
      setLoading: (loading) => { }
    }
  }
}
</script>
