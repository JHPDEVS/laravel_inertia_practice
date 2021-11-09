<template>
    <app-layout>
        <template #header>
            수강 신청자 리스트
        </template>
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
       <div class="w-2/3 mx-auto">
  <div class="bg-white shadow-md rounded my-6">
    <table class="text-left w-full border-collapse"> <!--Border collapse doesn't work on this site yet but it's available in newer tailwind versions -->
      <thead>
        <tr>
          <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">사용자 프로파일 이미지</th>
          <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">이름</th>
          <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">이메일</th>
        </tr>
      </thead>
      <tbody>
        <tr class="hover:bg-grey-lighter" v-for="(attend,i) in attends.data" v-bind:key="i">
          <td class="py-4 px-6 border-b border-grey-light"><img v-if="attend.profile_photo_path" class="object-cover h-20 w-20 rounded-full" :src="`/storage/${attend.profile_photo_path}`"  />
          <img v-else class="object-cover h-20 w-20 rounded-full"  :src="`https://ui-avatars.com/api/?name=${attend.name}&color=7F9CF5&background=EBF4FF`"/> </td>
          <td class="py-4 px-6 border-b border-grey-light">{{attend.name}}</td>
          <td class="py-4 px-6 border-b border-grey-light">{{attend.email}}</td>
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
        props: ['attends'],
        data: function () {
            return {
                header: '',
                header2: '',
                msg: '',
                page: [],
                pageLinks: this.$page.props.attends.links,
                pageId: '',
                attends: [],
                isLoading: 0,
                showAttend: false,
                searchQuery: '',
                total: 1,
                subjectCount: [],
            }
        },
        components: {
            AppLayout,

        },
  
        mounted() {
       
        },
        methods: {
         

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