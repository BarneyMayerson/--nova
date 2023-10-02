<template>
  <div>
    <Head title="Nyt Bestsellers" />

    <Heading class="mb-6 text-2xl">New York Times Bestsellers</Heading>

    <Card v-for="category in data.items" class="mb-6 px-6 py-4">
      <h2 class="text-xl font-bold mb-4">{{ category.display_name }}</h2>
      <ul class="flex space-x-6 justify-between">
        <li v-for="book in category.books">
          <img :src="book.book_image" class="w-32 aspect-[1/1.5]" alt="cover" />
          <h3 class="mt-2 font-bold w-32 truncate">{{ book.title }}</h3>
          <p class="mt-1 w-32 truncate">{{ book.author }}</p>
          <div class="flex mt-2 justify-end">
            <DefaultButton component="a" :href="book.buy_links[0]?.url">
              Buy
            </DefaultButton>
          </div>
        </li>
      </ul>
    </Card>
  </div>
</template>

<script setup>
import { onMounted, reactive } from "vue";

const data = reactive({
  items: [],
});

onMounted(() => {
  Nova.request()
    .get("/nova-vendor/nyt-bestsellers/")
    .then((response) => {
      data.items = response.data;
    });
});
</script>

<style>
/* Scoped Styles */
</style>
