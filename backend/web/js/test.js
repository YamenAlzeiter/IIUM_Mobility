import * as d3 from 'd3';

// Data for the bar chart
const data = [10, 20, 30, 40, 50];

// Create the SVG container
const width = 500;
const height = 300;
const barWidth = width / data.length;

const svg = d3.select('body').append('svg')
    .attr('width', width)
    .attr('height', height);

// Create bars
svg.selectAll('rect')
    .data(data)
    .enter().append('rect')
    .attr('x', (d, i) => i * barWidth)
    .attr('y', d => height - d * 5)
    .attr('width', barWidth - 1)
    .attr('height', d => d * 5)
    .attr('fill', 'steelblue');
