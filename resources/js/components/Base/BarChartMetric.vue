<template>
    <loading-card :loading="loading" class="px-6 py-4 nova-bar-metrics">
        <h3 class="flex mb-3 text-base text-80 font-bold">
            {{ title }}
            <span class="ml-auto font-semibold text-70 text-sm">({{ formattedAvg}} {{__('avg')}})</span>
        </h3>
        <div
            ref="chart"
            class="z-40 absolute pin rounded-b-lg ct-chart"
            style="top: 35%"
        />
    </loading-card>
</template>

<script>
import Chartist from "chartist";
import "chartist-plugin-tooltips";
import { SingularOrPlural } from "laravel-nova";

export default {
  name: "BaseBarChartMetric",

  props: {
    loading: Boolean,
    title: String,
    chartData: Array,
    prefix: "",
    suffix: "",
    precision: Number
  },

  data: () => ({ chartist: null }),

  watch: {
    chartData: function(newData, oldData) {
      this.renderChart();
    }
  },

  mounted() {
    this.chartist = new Chartist.Bar(
      this.$refs.chart,
      this.formattedChartData,
      {
        axisX: {
          showGrid: false,
          showLabel: true,
          offset: 0
        },
        axisY: {
          showGrid: false,
          showLabel: true,
          offset: 0
        },
        chartPadding: {
          top: 10,
          right: 0,
          bottom: 0,
          left: 0
        },
        distributeSeries: true,
        plugins: [
          Chartist.plugins.tooltip({
            anchorToPoint: true,
            transformTooltipTextFnc: value => {
              if (this.prefix) {
                return `${this.prefix}${value}`;
              }

              if (this.suffix) {
                const suffix = SingularOrPlural(value, this.suffix);
                return `${value} ${suffix}`;
              }

              return `${value}`;
            }
          })
        ]
      }
    );
  },

  methods: {
    renderChart() {
      this.chartist.update(this.formattedChartData);
    }
  },

  computed: {
    formattedChartData() {
      return { labels: this.formattedLabels, series: this.formattedData };
    },

    formattedLabels() {
      return _(this.chartData)
        .map(item => item.label)
        .value();
    },

    formattedData() {
      return _(this.chartData)
        .map(item => {
          return {
            value: item.value,
            meta: item.label
          };
        })
        .value();
    },

    formattedTotal() {
      return _.sumBy(this.chartData, "value");
    },

    formattedAvg() {
      return Number(_.meanBy(this.chartData, "value")).toFixed(this.precision);
    }
  }
};
</script>
<style>
/* Scoped Styles */
.nova-bar-metrics .ct-series-a .ct-bar {
  stroke-width: 10px;
}
</style>
