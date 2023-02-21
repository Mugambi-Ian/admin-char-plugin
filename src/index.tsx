import React, { useCallback, useState, useEffect, Fragment } from 'react';
import ReactDOM from 'react-dom';
import Loader from './components/Loader';
import Chart from './components/LineChart';
import Header from './components/Header';
import Empty from './components/Empty';



const AdminChart = () => {
  const [loading, setLoading] = useState(true);
  const [chartData, setChartData] = useState([]);

  const loadData = useCallback(async (days: number) => {
    setChartData([])
    const data = await fetch('/wp-json/admin-chart/v1/data?days=' + days)
    let values = await data.json()
    values = values.map((v: string, i: number) => {
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

  const isEmpty = chartData.length === 0
  return (
    <div className="wrap relative">
      <Header onChange={onChange} />
      {loading && <Loader />}
      {!loading &&
        <Fragment>
          {isEmpty && <Empty />}
          {!isEmpty && <Chart chartData={chartData} />}
        </Fragment>}
    </div>
  );
};

const container = document.getElementById('admin-chart-widget');

if (container) {
  ReactDOM.render(<AdminChart />, container);
}