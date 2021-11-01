<template>
    <app-layout>
        <template #header>
            
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <div
                    class="relative flex items-center self-center min-w-full max-w-xl p-4 overflow-hidden text-gray-600 focus-within:text-gray-400">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-6">
                        <button v-on:click="search"
                            class="p-1 focus:outline-none focus:shadow-none hover:text-blue-500">
                            <i class="fas fa-search"></i>
                        </button>
                    </span>
                    <input type="search" @keyup.enter="search" v-model="searchQuery"
                        class="w-full py-2 pl-4 pr-10 text-sm bg-gray-100 border border-transparent appearance-none rounded-tg placeholder-gray-400 focus:bg-white focus:outline-none focus:border-blue-500 focus:text-gray-900 focus:shadow-outline-blue"
                        style="border-radius: 25px, white-space: pre" placeholder="과목명으로 검색" autocomplete="off">

                </div>


            </div>
            <div class="bg-white px-4 py-3   items-center justify-between border-t border-gray-200 sm:px-6 lg:flex">
                <div class="flex-1 flex items-center justify-between ">
                    <div>
                        <nav class="relative z-0  flex-nowrap rounded-md shadow-sm -space-x-px lg:inline-flex"
                            aria-label="Pagination">
                            <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
                            <a v-for="(item,i) in pageLinks" v-bind:key="i">
                                <button @click="refreshPage(item.label)" v-if="item.active==true"
                                    class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">{{ item.label }}</button>
                                <button @click="refreshPage(item.label)" v-else
                                    class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-mediums">{{ item.label }}</button>
                            </a>

                        </nav>

                    </div>

                </div>
                <div>
                </div>
            </div>
            <div class="lg:flex ">
                <div v-if="total == 0">
                    <div class="alert alert-error">
                        <div class="flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="w-6 h-6 mx-2 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <label>검색된 게시글이 없습니다</label>
                        </div>
                    </div>
                </div>
                <table v-else class="table-compact  min-w-full border-collapse">
                    <thead class="text-center bg-gray-100 font-sans">
                        <tr class="hover:bg-grey-lighter">
                            <th>과목명</th>
                            <th>학점</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(subject,i) in subjects" v-bind:key=i
                            class="text-center justify-center border-b border-black-200 hover:bg-gray-100">
                        <th><a v-bind:href="`/show/${subject.id}`">{{subject.subjectName}}</a></th>
                            <th>{{ subject.grade }}</th>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        data: function () {
            return {
                header: '',
                header2: '',
                msg: '',
                page: [],
                pageLinks: [],
                pageId: '',
                subjects: [],
                isLoading: 0,
                showAttend: false,
                searchQuery: '',
                total: 1,
            }
        },
        components: {
            AppLayout,

        },
        mounted() {
          axios.get('/subject/index?page' + this.pageId)
          .then(response=>{
              this.subjects = response.data.subjects.data;
              this.pageLinks = response.data.subjects.links
              this.pageId = response.data.subjects.current_page
              this.page = response.data.subjects
          })
        },
        methods: {
            refreshPage(page) {
                if (page == "<") {
                    if (this.pageLinks[0].url) {
                        page = this.pageLinks[0].url.charAt(this.pageLinks[0].url.length - 1)
                    } else {
                        page = 1
                    }
                }
                if (page == ">") {
                    if (this.pageLinks[this.page.last_page + 1].url) {
                        page = this.pageLinks[this.page.last_page + 1].url.charAt(this.pageLinks[this.page.last_page +
                            1].url.length - 1)
                    } else {
                        page = this.page.last_page;
                    }
                }
                axios.get("/subject/index?page=" + page)
                        .then(response => {
                            this.page = response.data.subjects;
                            this.pageId = response.data.subjects.current_page
                            this.subjects = response.data.subjects.data;
                            this.pageLinks = response.data.subjects.links
                            console.log(response.data)
                })
            },
          
        }
    }
</script>
<style>
    jet-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
</style>