<template {{ $attributes }}>
  <li class="flex px-3 py-5 odd:bg-gray-50">
    <div class="pr-3">
      <a x-bind:href="'/users/' + comment.user.username" class="block h-10 w-10 rounded-full border">
        <template x-if="comment.user.avatar_url">
          <img x-bind:src="comment.user.avatar_url" x-bind:alt="comment.user.name" class="block h-full w-full rounded-full" />
        </template>
        <template x-if="!comment.user.avatar_url" x-data="{ name: comment.user.name }">
          <x-ui.avatar alpine class="block h-full w-full rounded-full" />
        </template>
      </a>
    </div>
    <div class="flex-1">
      <div class="mb-3 flex h-10 flex-col justify-center">
        <a x-bind:href="'/users/' + comment.user.username" class="block text-sm font-semibold capitalize text-primary-600"
          x-text='comment.user.name'></a>
        <span class="block text-xs" x-text="comment.time_ago"></span>
      </div>
      <div class='prose mb-3 max-w-none' x-html='comment.html_body'></div>
      @auth
        <div class="flex">
          <div class="ml-auto">
            <button x-bind:class="{ 'text-red-600': comment.liked }" class="leading-6" X-bind:disabled="$store.commentStore.likeLoading"
              x-on:click="$store.commentStore.likeToggle('{{ route('comments.like-toggle', '__id__') }}'.replace('__id__', comment.id), comment.id)">
              <i class="ft ft-heart"></i>
              <span x-text="comment.like_count || ''"></span></button>
          </div>
          <div class="ml-2">
            <template x-if="$store.authStore.auth.id === comment.user.id">
              <button class="ml-2 leading-6 text-red-600" X-bind:disabled="$store.commentStore.destroyLoading"
                x-on:click="$store.deleteConfirm(() => $store.commentStore.destroy('{{ route('comments.destroy', '__id__') }}'.replace('__id__', comment.id), comment.id))">
                <i class="ft ft-trash"></i>
              </button>
            </template>
          </div>
        </div>
      @endauth
    </div>
  </li>
</template>
