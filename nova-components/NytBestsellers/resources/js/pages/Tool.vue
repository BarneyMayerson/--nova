<template>
  <div>
    <Head title="Nyt Bestsellers" />

    <Heading class="mb-6">New York Times Bestsellers</Heading>

    <Card>
      {{ data.items }}
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
