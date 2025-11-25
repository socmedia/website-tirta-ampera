# Dashboard

## Table of Contents

1. [Description](#description)
2. [Summary Widgets](#summary-widgets)
    - [Collaboration](#1-collaboration)
    - [Contact Message](#2-contact-message)
    - [Applicant](#3-applicant)
    - [Visitor](#4-visitor)
3. [Charts](#charts)
    - [Visitor Chart](#1-visitor-chart)
    - [Device Chart](#2-device-chart)
4. [Date Range](#date-range)
5. [Notes](#notes)

---

## Description

The **Dashboard** menu displays a summary of key website data and analytics.  
Administrators can view quick statistics (widgets) and data visualizations in the form of charts.  
All data can be filtered by **date range** using the date range picker.

📍 URL: [/panel](/panel)

---

## Summary Widgets

Widgets display data as concise numbers, shown in a 4-column grid.

### 1. Collaboration

-   Shows the number of collaboration requests received in the selected period.

### 2. Contact Message

-   Shows the number of contact messages received via the website form.

### 3. Applicant

-   Shows the number of job applicants received.

### 4. Visitor

-   Shows the total number of website visitors based on Google Analytics data.

---

## Charts

In addition to widgets, the Dashboard also provides analytics charts.

### 1. Visitor Chart

-   Displays the trend of visitor numbers over the selected period.
-   Data is sourced from Google Analytics (screen page views / users).
-   Shown as a line or area chart.

### 2. Device Chart

-   Shows the distribution of visitors by **Operating System (OS)**.
-   Uses Google Analytics data from `fetchTopOperatingSystems`.
-   By default, displays the **top 5 OS**.
-   Data is presented as a pie/donut chart.

## Date Range

-   The **Date Range Picker** is available at the top of the dashboard.
-   Users can select a start date (`start`) and end date (`end`).
-   If only one day is selected, it is displayed as **on {date}**.
-   If a range is selected, it is displayed as **from {date} to {date}**.
-   Default (if empty) → last 7 days.
-   Any change in the range will trigger updates to all widgets & charts.

---

## Notes

-   The dashboard only displays **read-only** data; there are no CRUD actions.
-   Visitor & device chart data is entirely sourced from **Google Analytics**.
-   It is recommended to use **caching** at the service layer to reduce the number of API requests to Google Analytics.
-   All data is synchronized with the `dateRange` to ensure consistency across widgets & charts.
