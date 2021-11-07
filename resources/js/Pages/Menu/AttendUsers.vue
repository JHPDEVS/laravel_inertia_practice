<template>
    <app-layout>
        <template #header>
            수강 신청자 리스트
        </template>
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
        <tr class="hover:bg-grey-lighter" v-for="(attend,i) in attends" v-bind:key="i">
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
                pageLinks: [],
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
        computed: {

            countItem: function () {
                let sum = 0;
                this.attends.forEach(function (item) {
                    sum +=1;
                });

                return sum;
            }
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