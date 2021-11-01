<template>
    <app-layout>
        <template #header>
            수강목록록
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <marquee>This text will scroll from right to left</marquee>
                학점 총합 : {{ totalItem }}

                과목 개수 : {{ countItem }}

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
                            <th>수강신청자 수</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(attend,i) in attends" v-bind:key=i
                            class="text-center justify-center border-b border-black-200 hover:bg-gray-100">
                            <th><a v-bind:href="`/show/${attend.id}`">{{attend.subjectName}}</a></th>
                            <th>{{ attend.grade }}</th>
                             <th>{{ subjectCount[i].count }}</th>
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
                attends: [],
                isLoading: 0,
                showAttend: false,
                searchQuery: '',
                total: 1,
                subjectCount: '',
            }
        },
        components: {
            AppLayout,

        },
        computed: {
            totalItem: function () {
                let sum = 0;
                this.attends.forEach(function (item) {
                    sum += (parseInt(item.grade));
                });

                return sum;
            },

            countItem: function () {
                let sum = 0;
                this.attends.forEach(function (item) {
                    sum +=1;
                });

                return sum;
            }
        },
        mounted() {
            axios.get('/attend/index?page' + this.pageId)
                .then(response => {
                    this.attends = response.data.attends.data;
                    this.pageLinks = response.data.attends.links
                    this.pageId = response.data.attends.current_page
                    this.subjectCount = response.data.subjects;
                    this.page = response.data.attends
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
                axios.get("/attend/index?page=" + page)
                    .then(response => {
                        this.page = response.data.attends;
                        this.pageId = response.data.attends.current_page
                        this.subjects = response.data.attends.data;
                        this.pageLinks = response.data.attends.links
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