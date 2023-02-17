# admin-chart-plugin

The plugin has a setting page

<img width="100" alt="image" src="https://user-images.githubusercontent.com/46242846/219560000-3e6ccd9f-6df3-472c-832d-06df883ddfb2.png">

From here the adim is promted to enter data sample for 5 weeks, 7 days each week i.e week_1 = 1,2,42,50,790,123,5995 

<img width="415" alt="image" src="https://user-images.githubusercontent.com/46242846/219560299-056aeecb-44d3-4003-8e1a-ffd8b48dbd3e.png">

the values are stored in the wp_options table and when the admin visits the dashboard the values are then displayed with options to get the fisrt 7, 15 or 30 days.

<img width="556" alt="image" src="https://user-images.githubusercontent.com/46242846/219560791-f3292d09-3463-4700-be4c-1b65e6aa8694.png">

<img width="553" alt="image" src="https://user-images.githubusercontent.com/46242846/219560907-24d1abd4-bc8e-4fbc-914d-9ede05f129a9.png">


## Solution 

The plugin:
- implements a rest api that returns an array of values for the days requested. ie request days=5 will return an array of the 1st five values from week 1.
- implements a widget on the dashboard to print a chart for the selected days.
- implements an options page to act as the settings page for the plugin.

### Video link




- 


