<template>
    <app-layout>
        <div class="p-2 bg-gray-50 dark:bg-gray-900 flex items-center justify-center w-screen lg:px-24">
                <div class="flex items-center justify-center w-screen lg:px-24 py-2">
            <div class="editor  flex flex-col text-gray-800 border border-gray-300 p-4 shadow-lg max-w-2xl min-w-full">
                <input class="title bg-gray-100 border border-gray-300 p-2 mb-2 outline-none" spellcheck="false"
                    placeholder="과목명" type="text" v-model="subject.subjectName">
                    <span v-if="msg.title" class="flex items-center font-medium tracking-wide text-red-500 text-xs  ml-1">{{ msg.title }}</span>
                      <input class="title bg-gray-100 border border-gray-300 p-2 mb-2 outline-none" spellcheck="false"
                    placeholder="학점" type="text" v-model="subject.grade">
                    <span v-if="msg.grade" class="flex items-center font-medium tracking-wide text-red-500 text-xs  ml-1">{{ msg.grade }}</span>
              <ckeditor :editor="editor" v-model="subject.description" :config="editorConfig" />
                <span v-if="msg.content" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">{{ msg.content }}</span>
        
                <div class="buttons flex">
                    <button @click="moveList" class="btn border border-gray-300 p-1 px-4 font-semibold cursor-pointer text-gray-500 ml-auto"
                       >취소</button>
                    <div class="btn border border-indigo-500 p-1 px-4 font-semibold cursor-pointer text-gray-200 ml-2 bg-indigo-500"
                        @click="save">수정</div>
                </div>
            </div>
        </div>
        </div>

    </app-layout>
    

</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Dialog from '@/Jetstream/DialogModal'
    import axios from 'axios'
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
    import CKEditor from '@ckeditor/ckeditor5-vue'
    export default {
        props: ['subject_id'],
        components: {
            AppLayout,
            Dialog,
            ckeditor : CKEditor.component
        },
        data: () => ({
            subject: '',
            dialog: false,
            posts: [],
            msg: [],
                  editor: ClassicEditor, 
            editorData: '<p>Content of the editor.</p>', 
            editorConfig: { height: '500px', language: 'ko' }
        }),
        computed: {

        },
        mounted() {
            axios.get('/subject/show/' + this.subject_id)
                .then(response => {
                    this.subject = response.data.subjects
                })
        },
        methods: {
            closeDialog() {
                this.dialog = false
            },
            moveList() {
                window.location.href = '/index'
            },
            save() {
                const bodyFormData = new FormData();
                bodyFormData.append('subjectName', this.subject.subjectName);
                bodyFormData.append('grade', this.subject.grade);
                bodyFormData.append('description',this.subject.description)
                axios.post('/subject/edit/' + this.subject_id, bodyFormData)
                    .then(response => {
                        if (response.data.status == "false") {
                            this.msg = response.data.data
                            if (response.data.message) {
                                alert(response.data.message)
                                this.msg = ''
                                this.disabled()
                            }

                        } else {
                            this.msg = ''
                            alert("게시글 수정완료")
                            this.moveList();
                        }
                    })
                    .catch(error => {
                        alert("에러")
                    })
            },
            }
    
        ,
    }
</script>
<style>
    a:hover {
        text-decoration: underline;
    }
</style>