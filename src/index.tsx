import React, { useCallback, useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import { LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer } from 'recharts';



const AdminChart = () => {
  const [loading, setLoading] = useState(true);
  const [chartData, setChartData] = useState([]);

  const loadData = useCallback(async (days) => {
    setChartData([])
    const data = await fetch('/wp-json/admin-chart/v1/data?days=' + days)
    let values = await data.json()
    values = values.map((v, i) => {
      return {
        day: i + 1,
        value: parseInt(v)
      }
    })
    setChartData(values)
  }, [])


  useEffect(() => {
    loadData(7).then(() => {
      setLoading(false)
    })
  }, [])


  const onChange = async (e) => {
    console.log(e.target.value)
    setLoading(true)
    await loadData(e.target.value);
    setLoading(false);
  }


  return (
    <div>
      <div style={{ display: "flex", width: "100%" }}>
        <h2 style={{ flex: 1 }}>Graph Widget</h2>
        <select name="chart-admin-days" onChange={onChange} defaultValue={7}>
          <option value={7}>7 Days</option>
          <option value={15}>15 Days</option>
          <option value={30}>30 Days</option>
        </select>
      </div>
      {chartData && <ResponsiveContainer width="100%" height={300}>
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
      </ResponsiveContainer>}
      {loading && <p className='loading-content'></p>}
    </div>
  );
};

const container = document.getElementById('admin-chart-widget');

if (container) {
  ReactDOM.render(<AdminChart />, container);
}