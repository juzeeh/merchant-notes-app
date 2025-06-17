<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg p-6">
      <div class="flex items-center justify-between">
        <div>
          <button @click="$router.push('/')" class="mb-2 text-blue-600 hover:text-blue-800 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Merchants
          </button>
          <h2 class="text-2xl font-bold text-gray-900">{{ merchant.name }}</h2>
          <p class="text-gray-600">{{ notes.length }} notes</p>
        </div>
        <button @click="showAddNoteForm = true" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200">
          Add Note
        </button>
      </div>
    </div>

    <!-- Add Note Form -->
    <div v-if="showAddNoteForm" class="bg-white shadow rounded-lg p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Add New Note</h3>
        <button @click="cancelAddNote" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <form @submit.prevent="addNote" class="space-y-4">
        <div>
          <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
          <input v-model="newNote.title" id="title" type="text" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"/>
        </div>

        <div>
          <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
          <select v-model="newNote.priority" id="priority"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
          </select>
        </div>

        <div>
          <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
          <textarea v-model="newNote.content" id="content" rows="4" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
        </div>

        <div class="flex space-x-3">
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200">Save Note</button>
          <button type="button" @click="cancelAddNote" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors duration-200">Cancel</button>
        </div>
      </form>
    </div>

    <!-- Search -->
    <div class="flex gap-4 mb-4">
      <input v-model="filters.keyword" @input="fetchNotes" type="text" placeholder="Search notes..."
        class="border px-2 py-1 rounded w-1/2" />
      <input v-model="filters.date" @change="fetchNotes" type="date" class="border px-2 py-1 rounded" />
    </div>

    <!-- Notes List -->
    <div class="space-y-4">
      <div v-for="note in notes" :key="note.id" class="bg-white shadow rounded-lg p-6">
        <div v-if="editingNote !== note.id">
          <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
              <div class="flex items-center space-x-2 mb-2">
                <h3 class="text-lg font-semibold text-gray-900">{{ note.title }}</h3>
                <span :class="getPriorityClass(note.priority)"
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">{{ note.priority }}</span>
              </div>
              <p class="text-gray-600 mb-2">{{ note.content }}</p>
              <p class="text-sm text-gray-500">{{ formatDate(note.created_at) }}</p>
              <p class="text-sm text-gray-500">Created: {{ formatTimeAgo(note.created_at) }}</p>
              <p v-if="note.updated_at !== note.created_at" class="text-xs text-gray-400">(edited {{ formatTimeAgo(note.updated_at) }})</p>
            </div>
            <div class="flex space-x-2 ml-4">
              <button @click="startEditNote(note)" class="text-blue-600 hover:text-blue-800" aria-label="Edit note">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
              </button>
              <button @click="deleteNote(note.id)" class="text-red-600 hover:text-red-800" aria-label="Delete note">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <div v-else>
          <form @submit.prevent="updateNote(note.id)" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Title</label>
              <input v-model="editForm.title" type="text" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Priority</label>
              <select v-model="editForm.priority"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Content</label>
              <textarea v-model="editForm.content" rows="4" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
            </div>

            <div class="flex space-x-3">
              <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200">Update Note</button>
              <button type="button" @click="cancelEdit" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors duration-200">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div v-if="notes.length === 0" class="text-center py-12 bg-white shadow rounded-lg">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900">No notes yet</h3>
      <p class="mt-1 text-sm text-gray-500">Get started by creating a new note for this merchant.</p>
      <div class="mt-6">
        <button @click="showAddNoteForm = true" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200">
          Add First Note
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import moment from 'moment'

export default {
  name: 'MerchantNotes',
  props: ['id'],
  data() {
    return {
      merchant: {},
      notes: [],
      filters: { keyword: '', date: '' },
      showAddNoteForm: false,
      editingNote: null,
      newNote: { title: '', content: '', priority: 'medium' },
      editForm: { title: '', content: '', priority: 'medium' }
    }
  },
  inject: ['showToast'],
  async mounted() {
    await this.fetchMerchantNotes()
  },
  methods: {
    async fetchMerchantNotes() {
      try {
        const { data } = await axios.get(`api/merchants/${this.id}/notes`)
        this.merchant = data.merchant
        this.notes = data.notes
      } catch (error) {
        console.error(error)
        this.showToast('Failed to load merchant notes', 'error')
      } 
    },
    async fetchNotes() {
      try {
        const { data } = await axios.get(`/api/merchants/${this.id}/notes/search`, {
          params: { keyword: this.filters.keyword, date: this.filters.date, merchant_id: this.id }
        })
        this.notes = data.notes
      } catch (error) {
        console.error(error)
        this.showToast('Failed to load notes', 'error')
      } 
    },
    async addNote() {
      try {
        const { data } = await axios.post(`api/merchants/${this.id}/notes`, this.newNote)
        this.notes.unshift(data.note)
        this.showToast('Note added successfully', 'success')
        this.cancelAddNote()
      } catch (error) {
        console.error(error)
        this.showToast('Failed to add note', 'error')
      }
    },
    startEditNote(note) {
      this.editingNote = note.id
      this.editForm = { title: note.title, content: note.content, priority: note.priority }
    },
    async updateNote(noteId) {
      try {
        const { data } = await axios.put(`api/notes/${noteId}`, this.editForm)
        const index = this.notes.findIndex(note => note.id === noteId)
        if (index !== -1) this.notes.splice(index, 1, data.note)
        this.showToast('Note updated successfully', 'success')
        this.cancelEdit()
      } catch (error) {
        console.error(error)
        this.showToast('Failed to update note', 'error')
      }
    },
    async deleteNote(noteId) {
      if (!confirm('Are you sure you want to delete this note?')) return
      try {
        await axios.delete(`api/notes/${noteId}`)
        this.notes = this.notes.filter(note => note.id !== noteId)
        this.showToast('Note deleted successfully', 'success')
      } catch (error) {
        console.error(error)
        this.showToast('Failed to delete note', 'error')
      }
    },
    cancelAddNote() {
      this.showAddNoteForm = false
      this.newNote = { title: '', content: '', priority: 'medium' }
    },
    cancelEdit() {
      this.editingNote = null
      this.editForm = { title: '', content: '', priority: 'medium' }
    },
    getPriorityClass(priority) {
      return {
        low: 'bg-green-100 text-green-800',
        medium: 'bg-yellow-100 text-yellow-800',
        high: 'bg-red-100 text-red-800'
      }[priority] || 'bg-yellow-100 text-yellow-800'
    },
    formatDate(dateString) {
      const date = new Date(dateString)
      return `${date.toLocaleDateString()} at ${date.toLocaleTimeString()}`
    },
    formatTimeAgo(dateString) {
      return moment(dateString).fromNow()
    }
  }
}
</script>
