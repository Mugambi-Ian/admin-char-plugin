import React from 'react';
import { LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer } from 'recharts';
//@ts-expect-error
import { FC } from 'react';

interface IProps {
  chartData: {
    day: number,
    value: number
  }[]
}

const Chart: FC<IProps> = ({ chartData }) => (<ResponsiveContainer width="100%" height={300}>
  <LineChart
    data={chartData}
    margin={{
      top: 40
    }}
  >
    <CartesianGrid strokeDasharray="3 3" />
    <XAxis dataKey="day" />
    <YAxis />
    <Tooltip />
    <Legend />
    <Line type="monotone" dataKey="value" stroke="#82ca9d" />
  </LineChart>
</ResponsiveContainer>)

export default Chart;