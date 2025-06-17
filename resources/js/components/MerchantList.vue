<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg p-6">
      <h2 class="text-2xl font-bold text-gray-900 mb-2">Merchants</h2>
      <p class="text-gray-600">Select a merchant to view and manage their notes</p>
    </div>

    <!-- Merchants Grid -->
    <div v-if="merchants.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div 
        v-for="merchant in merchants" 
        :key="merchant.id"
        class="bg-white shadow rounded-lg hover:shadow-lg transition-shadow duration-200 cursor-pointer"
        @click="viewMerchantNotes(merchant.id)"
      >
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">{{ merchant.name }}</h3>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
              {{ merchant.notes_count || 0 }} notes
            </span>
          </div>

          <div class="space-y-2 text-sm text-gray-600">
            <div v-if="merchant.email">📧 {{ merchant.email }}</div>
            <div v-if="merchant.phone">📞 {{ merchant.phone }}</div>
            <div v-if="merchant.address">📍 {{ merchant.address }}</div>
          </div>

          <div class="mt-4 pt-4 border-t border-gray-200">
            <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
              View Notes
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else class="text-center py-12 text-gray-500">
      <p>No merchants found. Add some to the database to get started.</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'MerchantList',
  data() {
    return {
      merchants: []
    }
  },
  async mounted() {
    try {
      const response = await axios.get('/api/merchants')
      this.merchants = response.data?.merchants || []
    } catch (error) {
      console.error('Failed to fetch merchants:', error)
      alert('Failed to load merchants')
    }
  },
  methods: {
    viewMerchantNotes(merchantId) {
      this.$router.push(`/merchants/${merchantId}/notes`)
    }
  }
}
</script>
