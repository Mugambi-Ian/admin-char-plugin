import React from 'react';
import ReactDOM from 'react-dom';

const AdminChart = () => {
  return (
    <div>
      <h2>Hello World</h2>
    </div>
  );
};

const container = document.getElementById('admin-chart-widget');

if (container) {
  ReactDOM.render(<AdminChart />, container);
}