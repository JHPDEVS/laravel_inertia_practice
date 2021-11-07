<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                교과목 등록
            </h2>
        </template>


    
        <div class="flex items-center justify-center w-screen lg:px-24 py-2">
            <div class="editor  flex flex-col text-gray-800 border border-gray-300 p-4 shadow-lg max-w-2xl min-w-full">
                <input class="title bg-gray-100 border border-gray-300 p-2 mb-2 outline-none" spellcheck="false"
                    placeholder="과목명" type="text" v-model="title">
                    <span v-if="msg.title" class="flex items-center font-medium tracking-wide text-red-500 text-xs  ml-1">{{ msg.title }}</span>
                      <input class="title bg-gray-100 border border-gray-300 p-2 mb-2 outline-none" spellcheck="false"
                    placeholder="학점" type="text" v-model="grade">
                    <span v-if="msg.grade" class="flex items-center font-medium tracking-wide text-red-500 text-xs  ml-1">{{ msg.grade }}</span>
                    <ckeditor :editor="editor" v-model="content" :config="editorConfig" />
                <span v-if="msg.content" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">{{ msg.content }}</span>
        
                <div class="buttons flex">
                    <a class="btn border border-gray-300 p-1 px-4 font-semibold cursor-pointer text-gray-500 ml-auto"
                        v-bind:href="`/free?page=${pageId}`">취소</a>
                    <div class="btn border border-indigo-500 p-1 px-4 font-semibold cursor-pointer text-gray-200 ml-2 bg-indigo-500"
                        @click="save">작성</div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import axios from 'axios'
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
    import CKEditor from '@ckeditor/ckeditor5-vue'
    export default {
        components: {
            AppLayout,
            ckeditor : CKEditor.component
        },
        data: () => ({
            msg: '',
            title: '',
            content: '교과목 설명',
            grade: '',
            editor: ClassicEditor, 
            editorData: '<p>Content of the editor.</p>', 
            editorConfig: { height: '500px', language: 'ko' }
        }),
       methods: {
            save() {
                const bodyFormData = new FormData();
                bodyFormData.append('content', this.content);
                bodyFormData.append('title', this.title);
                bodyFormData.append('grade', this.grade);
                axios.post('/subject/save', bodyFormData)
                    .then(response => {
                        if (response.data.status == "false") {
                            this.msg = response.data.data
                        } else if(response.data.status == "abort") {
                            alert('관리자가 아닙니다')
                        }
                            else {
                            this.msg = ''
                            alert("추가완료")
                        }
                    })
                    .catch(error => {
                        alert("에러")
                    })
            },
       }
            
        
    }
</script>
<style>
    a:hover {
        text-decoration: underline;
    }
</style>