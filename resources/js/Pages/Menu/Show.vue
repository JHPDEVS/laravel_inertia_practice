<template>
    <app-layout>
        <div class="p-2 bg-gray-50 dark:bg-gray-900 flex items-center justify-center w-screen lg:px-24">
            <div class="px-2 py-4 bg-white dark:bg-gray-800 shadow rounded-lg max-w-lg  min-w-full">
                <div class="flex mb-4">
                    <div class="ml-2 mt-0.5">
                        <span class="block font-medium text-base leading-snug text-black dark:text-gray-100">과목명 :
                            {{ subject.subjectName }}
                        </span>
                        <span class="block text-sm text-gray-500 dark:text-gray-400 font-light leading-snug">등록일 :
                            {{ subject.created_at }}</span>
                        <span class="block text-sm text-gray-500 dark:text-gray-400 font-light leading-snug">변경일 :
                            {{ subject.updated_at }}</span>
                    </div>
                </div>
                <p class="text-gray-800 dark:text-gray-100 leading-snug md:leading-normal">학점 : {{ subject.grade }} 학점
                </p>
                <p class="text-gray-800 dark:text-gray-100 leading-snug md:leading-normal">과목 설명 : {{ subject.description }} 
                </p>

                <div class="flex justify-between items-center">
                    <div class="flex ">
                    </div>
                    <div class="ml-1 btn-group">
                        <button
                        v-if="!isAttend"
                            class="bg-green-500 hover:bg-blue-300 text-white font-semibold hover:text-white py-2 mx-1 px-2 border border-gray-600 hover:border-transparent rounded" @click="attend">수강신청</button>
                        <button
                        v-else
                            class="bg-red-500 hover:bg-blue-300 text-white font-semibold hover:text-white py-2 mx-1 px-2 border border-gray-600 hover:border-transparent rounded" @click="attend">수강취소</button>
                        <button class="bg-blue-500 hover:bg-blue-300 text-white font-semibold hover:text-white py-2 mx-1 px-2 border border-gray-600 hover:border-transparent rounded"
                            @click="editSubject">수정</button>
                        <button
        
                            class="bg-red-500 hover:bg-red-300 text-white font-semibold hover:text-white py-2 mx-1 px-2 border border-gray-600 hover:border-transparent rounded" @click="openDelete">삭제</button>
                    </div>

                </div>


            </div>
        </div>

    </app-layout>
    <Dialog :show="dialog" @close="closeDialog">

        <template #title>
            삭제
        </template>

        <template #content>
           삭제하시겠습니까?
        </template>

        <template #footer>
            <button type="button"
                class="ml-2 bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded"
                @click="del">
                삭제
            </button>
            <button type="button"
                class="ml-2 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                @click="closeDialog">
                닫기
            </button>

        </template>
    </Dialog>

</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Dialog from '@/Jetstream/DialogModal'
    import axios from 'axios'
    export default {
        props: ['subject_id'],
        components: {
            AppLayout,
            Dialog,
        },
        data: () => ({
            subject: '',
            dialog: false,
            isAttend: false,
            posts: [],
        }),
        computed: {

        },
        mounted() {
            axios.get('/subject/show/' + this.subject_id)
                .then(response => {
                    this.subject = response.data.subjects
                    this.isAttend = response.data.attend;
                })
        },
        methods: {
            closeDialog() {
                this.dialog = false
            },
            moveList() {
                window.location.href = '/index'
            },
            editSubject() {
                window.location.href = '/edit/' + this.subject_id
            },
            refresh() {
              axios.get('/subject/show/' + this.subject_id)
                .then(response => {
                    this.subject = response.data.subjects
                    this.isAttend = response.data.attend;
                })
            },
            openDelete() {
                this.dialog = true;
            },
            del() {
                //  let value = {
                //     user_id: this.$page.props.user.id
                // }

                axios.delete('/subject/delete/' + this.subject_id)
                    .then(response => {
                        alert(response.data.message)
                        if (response.data.status == 'ture') {
                           this.moveList()
                        }
                    })
            },
            attend() {
                 let value = {
                    user_id: this.$page.props.user.id
                }
                axios.post('/subject/attend/' + this.subject_id,value)
                .then(response=>{
                    alert(response.data.msg)
                    this.refresh()
                })
            }
        },
    }
</script>
<style>
    a:hover {
        text-decoration: underline;
    }
</style>