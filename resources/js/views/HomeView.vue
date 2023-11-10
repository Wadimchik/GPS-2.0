<template>
  <div class="page-wrap">
    <!-- Content-->
    <div class="md-content">

      <!-- Section -->
      <section class="awe-section awe-skin-dark display-flex-center">
        <div class="awe-overlay"></div>
        <div class="container">

          <!-- comming-soon -->
          <div class="comming-soon-01">
            <h3 class="comming-soon-01__title">Сайт в разработке</h3>
          </div>

        </div>
      </section>
      <!-- End / Section -->

    </div>
    <!-- End / Content-->
  </div>
</template>

<script>
import HelloWorld from '@/js/components/HelloWorld.vue'

export default {
  name: 'HomeView',
  components: {
    HelloWorld
  }
}

</script>


<style lang='scss' scoped>
.awe-section {
  height: 100vh;
  background-image: url(@/img/coming-soon.jpg);
}
</style>
