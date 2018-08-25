<template>
    <BaseBarChartMetric
        :title="card.name"
        :chart-data="chartData"
        :loading="loading"
        :prefix="prefix"
        :suffix="suffix"
        :precision="precision"
    />
</template>

<script>
import { Minimum } from "laravel-nova";
import BaseBarChartMetric from "./Base/BarChartMetric";

export default {
  components: {
    BaseBarChartMetric
  },

  props: {
    card: {
      type: Object,
      required: true
    },
    resourceName: {
      type: String,
      default: ""
    },
    resourceId: {
      type: [Number, String],
      default: ""
    }
  },

  data: () => ({
    loading: true,
    chartData: [],
    prefix: "",
    suffix: "",
    precision: 2
  }),

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.loading = true;

      Minimum(Nova.request().get(this.cardEndpoint)).then(
        ({ data: { value: { value, prefix, suffix, precision } } }) => {
          this.chartData = value;
          this.prefix = prefix || "";
          this.suffix = suffix || "";
          this.precision = precision || 2;
          this.loading = false;
        }
      );
    }
  },
  computed: {
    cardEndpoint() {
      if (this.resourceName && this.resourceId) {
        return `/nova-api/${this.resourceName}/${this.resourceId}/metrics/${
          this.card.uriKey
        }`;
      } else if (this.resourceName) {
        return `/nova-api/${this.resourceName}/metrics/${this.card.uriKey}`;
      } else {
        return `/nova-api/metrics/${this.card.uriKey}`;
      }
    }
  }
};
</script>
