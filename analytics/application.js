// Copyright 2007 Google Inc. All Rights Reserved.

var VisualizationModule = {
  sendManager: function(manager) {
    goog.analytics.Ajax.send(
        manager._get(analytics.Properties._LOCATION_PATH) + '?' +
        manager._getQueryString());
  },

  changeDateRange: function(dateRange) {
    gaNavigator.onDateSliderChange(dateRange);
  },

  changeDateRangeAndComparisonDateRange: function(dateRange,
      comparisonDateRange, segment) {
    gaNavigator.onDateSliderChange(dateRange, comparisonDateRange, segment);
  },

  changeDateRangeAndComparisonType: function(dateRange, comparisonType) {
    gaNavigator.onDateSliderChange(dateRange, null, null, comparisonType);
  },

  changeComparisonType: function(comparisonType) {
    gaNavigator.onDateSliderChange(null, null, null, comparisonType);
  },

  changeSortBy: function() {
    var manager = analytics.PropertyManager._getInstance();
    manager._set(analytics.Properties._EVENT_ID, 'TableChanged');
    if (table._getData().State.ChartColumn) {
      manager._set(analytics.Properties._TABLE_CHART_COLUMN,
          table._getData().State.ChartColumn);
    }
    manager._set(analytics.Properties._TABLE_SORT_COLUMN,
        table.getSortingParam());
    manager._set(analytics.Properties._TABLE_START_ROW, 0);

    VisualizationModule.sendManager(manager);
  },

  changeChartColumn: function() {
    var manager = analytics.PropertyManager._getInstance();
    manager._set(analytics.Properties._EVENT_ID, 'TableChanged');
    VisualizationModule.sendManager(manager);
  },

  changeView: function() {
    var manager = analytics.PropertyManager._getInstance();
    var newViewId = table._getData().State.View;
    manager._set(analytics.Properties._EVENT_ID, 'ViewChanged');
    manager._set(analytics.Properties._TABLE_VIEW, newViewId);
    if (table._getData().State.View == 0) {
      manager._set(analytics.Properties._TABLE_SORT_COLUMN, '');
    }

    VisualizationModule.sendManager(manager);
  },

  changeTab: function(tab, opt_lastTab) {
    var manager = analytics.PropertyManager._getInstance();
    manager._set(analytics.Properties._EVENT_ID, 'TabChanged');
    manager._set(analytics.Properties._TABLE_TAB, tab);
    if (opt_lastTab) {
      manager._set(analytics.Properties._TABLE_LAST_TAB, opt_lastTab);
    } else {
      manager._set(analytics.Properties._TABLE_LAST_TAB, 0);
    }
    manager._set(analytics.Properties._TABLE_START_ROW, 0);
    if (tab == 0) {
      manager._set(analytics.Properties._TABLE_CHART_COLUMN, 0);
    } else {
      manager._set(analytics.Properties._TABLE_CHART_COLUMN, 1);
    }
    manager._set(analytics.Properties._TABLE_SORT_COLUMN, '');

    // need to reset the pivot metrics and sort column (but not direction)
    if (window['table'] && table._getData().State.View == 4) {
      manager.clear(analytics.Properties._TABLE_PIVOTED_METRICS);
      table.resetSortColumnParameters_(manager);
    }

    // need to reset column pagination start
    manager.clear(analytics.Properties._TABLE_START_COLUMN);

    VisualizationModule.sendManager(manager);
  },

  changeSubTab: function() {
    var manager = analytics.PropertyManager._getInstance();
    var selectedSubTabs = subTabView.getSelectedTabs();
    manager._set(analytics.Properties._EVENT_ID, 'SubTabChanged');
    manager._set(analytics.Properties._SUBTABS, selectedSubTabs.join(','));
    VisualizationModule.sendManager(manager);
  },

  changeSortOrder: function() {
    var manager = analytics.PropertyManager._getInstance();
    manager._set(analytics.Properties._EVENT_ID, 'TableChanged');
    if (table._getData().State.ChartColumn) {
      manager._set(analytics.Properties._TABLE_CHART_COLUMN, table._getData().State.ChartColumn);
    }
    manager._set(analytics.Properties._TABLE_SORT_ORDER, table._getData().State.SortOrder);
    manager._set(analytics.Properties._TABLE_START_ROW, 0);
    VisualizationModule.sendManager(manager);
  },

  changePage: function() {
    var manager = analytics.PropertyManager._getInstance();
    manager._set(analytics.Properties._EVENT_ID, 'TableChanged');
    if (table._getData().State.ChartColumn) {
      manager._set(analytics.Properties._TABLE_CHART_COLUMN, table._getData().State.ChartColumn);
    }
    manager._set(analytics.Properties._TABLE_START_ROW, table._getData().RowStart);
    manager._set(analytics.Properties._TABLE_ROW_COUNT, table._getData().RowShow);
    manager._set(analytics.Properties._TABLE_START_COLUMN, table._getData().ColumnStart);
    manager._set(analytics.Properties._TABLE_COLUMN_COUNT, table._getData().ColumnShow);
    VisualizationModule.sendManager(manager);
  },

  changeSearch: function() {
    var manager = analytics.PropertyManager._getInstance();
    manager._set(analytics.Properties._EVENT_ID, 'Filter');
    if (table._getData().State.ChartColumn) {
      manager._set(analytics.Properties._TABLE_CHART_COLUMN, table._getData().State.ChartColumn);
    }
    manager._set(analytics.Properties._FILTER, table._getData().FilterString);
    manager._set(analytics.Properties._FILTER_TYPE, table._getData().FilterType);
    manager._set(analytics.Properties._TABLE_START_ROW, 0);
    VisualizationModule.sendManager(manager);
  },

  changeSegmentBy: function(segmentBy) {
    var manager = analytics.PropertyManager._getInstance();
    if (typeof(table) == 'object') {
      manager._set(analytics.Properties._EVENT_ID, 'NarrativeChanged');
      manager._set(analytics.Properties._TABLE_CHART_COLUMN,
          table._getData().State.ChartColumn);
      manager._set(analytics.Properties._FILTER, '');
      manager._set(analytics.Properties._TABLE_START_ROW, 0);
      manager._set(analytics.Properties._SEGMENT_BY, segmentBy);
      manager._set(analytics.Properties._SEGMENT, 1);

      VisualizationModule.sendManager(manager);
    } else {
      var path = manager._get(analytics.Properties._LOCATION_PATH);

      var newPropertyManager = analytics.PropertyManager._getNewInstance();
      newPropertyManager._addProperties(manager._getQueryString());

      newPropertyManager._set(analytics.Properties._EVENT_ID, '');
      newPropertyManager._set(analytics.Properties._SEGMENT, '1');
      newPropertyManager._set(analytics.Properties._SEGMENT_BY, segmentBy);

      newPropertyManager._set(analytics.Properties._EVENT_ID, '');

      gaNavigator.changeLocation(path + '?' +
          newPropertyManager._getQueryString());
    }
  },

  changeSegmentation: function(showSegment, viewId) {
    var manager = analytics.PropertyManager._getInstance();
    var path = manager._get(analytics.Properties._LOCATION_PATH);
    var newPropertyManager = analytics.PropertyManager._getNewInstance();
    newPropertyManager._addProperties(propertyManager._getQueryString());
    newPropertyManager._set(analytics.Properties._SEGMENT, (showSegment ? '1' : '0'));
    newPropertyManager._set(analytics.Properties._EVENT_ID, '');
    newPropertyManager._set(analytics.Properties._TABLE_VIEW, viewId);
    gaNavigator.changeLocation(path + '?' + newPropertyManager._getQueryString());
  },

  changeSliceBy: function(slice) {
    var manager = analytics.PropertyManager._getInstance();
    manager._set(analytics.Properties._EVENT_ID, 'NarrativeChanged');
    if (typeof(table) == 'object') {
      manager._set(analytics.Properties._TABLE_CHART_COLUMN, table._getData().State.ChartColumn);
      manager._set(analytics.Properties._FILTER, '');
      manager._set(analytics.Properties._TABLE_START_ROW, '0');
    }
    manager._set(analytics.Properties._SLICE_BY, slice);
    VisualizationModule.sendManager(manager);
  },

  changeDetailKeyword: function(drilldown) {
    var manager = analytics.PropertyManager._getInstance();
    manager._set(analytics.Properties._EVENT_ID, 'Filter');
    if (table._getData().State.ChartColumn) {
      manager._set(analytics.Properties._TABLE_CHART_COLUMN, table._getData().State.ChartColumn);
    }
    if (drilldown && drilldown != '') {
      manager._set(analytics.Properties._DRILLDOWN, drilldown);
    }
    VisualizationModule.sendManager(manager);
  },

  changeDrilldown: function(newDrilldown) {
    var manager = analytics.PropertyManager._getInstance();
    manager._set(analytics.Properties._EVENT_ID, 'DrilldownChanged');
    manager._set(analytics.Properties._DRILLDOWN, newDrilldown);
    manager._set(analytics.Properties._DRILLDOWN2, '');
    manager._set(analytics.Properties._DRILLDOWN3, '');
    VisualizationModule.sendManager(manager);
  },

  turnOffSecondaryLine: function() {
    var manager = analytics.PropertyManager._getInstance();
    manager._set(analytics.Properties._EVENT_ID, 'GraphChanged');

    manager._set(analytics.Properties._GRAPH_LINE_COUNT, 1);
    document.getElementById('toggle_button').className = 'toggle_button off';

    VisualizationModule.sendManager(manager);
  },

  changeBenchmarkId: function(benchmarkId) {
    var manager = analytics.PropertyManager._getInstance();
    manager._set(analytics.Properties._EVENT_ID, 'BenchmarkChanged');
    manager._set(analytics.Properties._BENCHMARK_ID, benchmarkId);
    manager._set(analytics.Properties._COMPARISON_TYPE, 'benchmark');
    VisualizationModule.sendManager(manager);
  },

  changeGoal: function(goalNumber) {
    var manager = analytics.PropertyManager._getInstance();
    var params = analytics.Properties._GOAL + '=' + goalNumber;
    VisualizationModule.changeReport(
        manager._get(analytics.Properties._LOCATION_PATH), params);
  },

  changeReport: function(report, params, opt_disableAjax) {
    analytics.Navigator.changeLocationWithState(
        report, false, params, opt_disableAjax);
    return false;
  },

  changeToReportWithUrl: function(link, opt_disableAjax) {
    var queryStringIndex = link.indexOf('?');
    var newManager = analytics.PropertyManager._getNewInstance();
    newManager._addProperties(analytics.PropertyManager
        ._getInstance()._getPersistentQueryString());

    if (queryStringIndex > -1) {
      newManager._addProperties(link.substring(queryStringIndex + 1));
      link = link.substring(0, queryStringIndex);
    }

    if (queryStringIndex > -1) {
      gaNavigator.changeLocation(link + '?' + newManager._getQueryString(),
          opt_disableAjax);
    } else {
      gaNavigator.changeLocation(link, opt_disableAjax);
    }

    return false;
  },

  changeReportAndComparison: function(report, comparison) {
    var propertyManager = analytics.PropertyManager._getInstance();
    propertyManager._set(analytics.Properties._COMPARISON_TYPE, comparison);
    return this.changeReport(report);
  },

  launchOverlay: function() {
    var manager = analytics.PropertyManager._getInstance();
    var newManager = manager._cloneAll();
    var url = 'overlay_launch?' + newManager._getQueryString();
    var mywin = window.open(url, '', 'scrollbars=yes,menubar=yes,toolbar=yes,location=yes,width=800,height=600,resizable=yes');
    mywin.focus();
    return false;
  },

  launchDefaultOverlay: function() {
    var manager = analytics.PropertyManager._getInstance();
    var newManager = manager._cloneAll();
    newManager._set(analytics.Properties._DRILLDOWN, '');
    newManager._set(analytics.Properties._DRILLDOWN2, '');
    newManager._set(analytics.Properties._DRILLDOWN3, '');
    var url = 'overlay_launch?' + newManager._getQueryString();
    var mywin = window.open(url, '', 'scrollbars=yes,menubar=yes,toolbar=yes,location=yes,width=800,height=600,resizable=yes');
    mywin.focus();
    return false;
  },

  changeSelectorFilter: function(filterString) {
    var manager = analytics.PropertyManager._getInstance();
    manager._set(analytics.Properties._EVENT_ID, 'SelectorFilterChanged');
    manager._set(analytics.Properties._SELECTOR_FILTER, filterString);
    goog.analytics.Ajax.sendCustomLoading(
        manager._get(analytics.Properties._LOCATION_PATH) + '?' +
        manager._getQueryString(), 'ContentControl_menu_loading');
  },

  changeSegmentView: function(viewId) {
    var manager = analytics.PropertyManager._getInstance();
    var path = manager._get(analytics.Properties._LOCATION_PATH);
    var clonedManager = analytics.PropertyManager._getInstance()._cloneAll();
    clonedManager._set(analytics.Properties._EVENT_ID, '');
    clonedManager._set(analytics.Properties._TABLE_VIEW, viewId);
    clonedManager._set(analytics.Properties._SEGMENT, '1');

    gaNavigator.changeLocation(path + '?' + clonedManager._getQueryString());
  },

  changeAnalyzeContent: function(analyzeUrl, opt_qParam) {
    var manager = analytics.PropertyManager._getInstance();
    var clonedManager = manager._clonePersistent();

    clonedManager._set(analytics.Properties._DRILLDOWN,
        manager._get(analytics.Properties._DRILLDOWN));

    // Including optional query parameter if it's being passed in by the caller
    gaNavigator.changeLocation(analyzeUrl + '?' +
        clonedManager._getQueryString() + (opt_qParam ? opt_qParam : ''));
  },

  changeAnalyzeSiteSearchCategory: function(analyzeUrl) {
    var manager = analytics.PropertyManager._getInstance();
    var clonedManager = manager._clonePersistent();

    clonedManager._set(analytics.Properties._DRILLDOWN,
        manager._get(analytics.Properties._DRILLDOWN));
    clonedManager._set(analytics.Properties._DRILLDOWN2,
        manager._get(analytics.Properties._DRILLDOWN2));

    if (analyzeUrl.indexOf('content') > -1 ||
        analyzeUrl.indexOf('refinement') > -1) {
      clonedManager._set(analytics.Properties._TABLE_VIEW, 1);
    }

    gaNavigator.changeLocation(analyzeUrl + '?' +
        clonedManager._getQueryString());
  },

  changeAnalyzeSiteSearchContent: function(analyzeUrl) {
    var manager = analytics.PropertyManager._getInstance();
    var clonedManager = manager._clonePersistent();

    clonedManager._set(analytics.Properties._DRILLDOWN,
        manager._get(analytics.Properties._DRILLDOWN));
    clonedManager._set(analytics.Properties._DRILLDOWN2,
        manager._get(analytics.Properties._DRILLDOWN2));

    if (analyzeUrl.indexOf('keyword_content') > -1) {
      clonedManager._set(analytics.Properties._TABLE_VIEW, 1);
    }

    gaNavigator.changeLocation(analyzeUrl + '?' +
        clonedManager._getQueryString());
  },

  changeAnalyzeSiteSearchResult: function(analyzeUrl) {
    var manager = analytics.PropertyManager._getInstance();
    var clonedManager = manager._clonePersistent();

    clonedManager._set(analytics.Properties._DRILLDOWN,
        manager._get(analytics.Properties._DRILLDOWN));
    clonedManager._set(analytics.Properties._DRILLDOWN2,
        manager._get(analytics.Properties._DRILLDOWN2));

    if (analyzeUrl.indexOf('keyword_content') > -1) {
      clonedManager._set(analytics.Properties._TABLE_VIEW, 1);
    }

    gaNavigator.changeLocation(analyzeUrl + '?' +
        clonedManager._getQueryString());
  },

  changeAnalyzeSiteSearchKeyword: function(analyzeUrl) {
    var manager = analytics.PropertyManager._getInstance();
    var clonedManager = manager._clonePersistent();

    clonedManager._set(analytics.Properties._DRILLDOWN,
        manager._get(analytics.Properties._DRILLDOWN));
    if (analyzeUrl.indexOf('refinement') > -1) {
      clonedManager._set(analytics.Properties._TABLE_VIEW, 1);
    }

    gaNavigator.changeLocation(analyzeUrl + '?' +
        clonedManager._getQueryString());
  },

  redirectReport: function(report, params, opt_disableAjax) {
    var clonedManager = analytics.PropertyManager._getInstance()._cloneAll();

    if (params && params != '') {
      clonedManager._addProperties(params);
    }
    clonedManager._set(analytics.Properties._EVENT_ID, '');

    gaNavigator.changeLocation(report + '?' + clonedManager._getQueryString() +
        getLimitParam(), opt_disableAjax);
    return false;
  },

  changeGeoMap: function(targetId, zoomLevel, segmentBy) {
    var clonedManager = analytics.PropertyManager._getInstance()._cloneAll();
    clonedManager._set(analytics.Properties._DRILLDOWN, targetId);
    clonedManager._set(analytics.Properties._GEOMAP_ZOOM_LEVEL, zoomLevel);
    clonedManager._set(analytics.Properties._SEGMENT_BY, segmentBy);
    clonedManager._set(analytics.Properties._EVENT_ID, '');

    gaNavigator.changeLocation((zoomLevel == 'CITY' ? 'city?' : 'maps?') +
        clonedManager._getQueryString());
  },

  segmentMap: function(segmentBy) {
    var clonedManager = analytics.PropertyManager._getInstance()._cloneAll();
    clonedManager._set(analytics.Properties._SEGMENT_BY, segmentBy);
    clonedManager._set(analytics.Properties._SEGMENT, '1');
    clonedManager._set(analytics.Properties._EVENT_ID, '');

    gaNavigator.changeLocation('map_detail?' +
        clonedManager._getQueryString());
  },

  returnToMap: function(segmentBy) {
    var clonedManager = analytics.PropertyManager._getInstance()._cloneAll();
    clonedManager._set(analytics.Properties._SEGMENT_BY, segmentBy);
    clonedManager._set(analytics.Properties._SEGMENT, '1');
    clonedManager._set(analytics.Properties._EVENT_ID, '');

    gaNavigator.changeLocation('maps?' + clonedManager._getQueryString());
  },

  changePathSelectorPagination: function(sectionName, newStartRow) {
    var manager = analytics.PropertyManager._getInstance();
    if (sectionName == 'initial') {
      manager._set(analytics.Properties._PATH_INIT_START_ROW, newStartRow);
    } else {
      manager._set(analytics.Properties._PATH_END_START_ROW, newStartRow);
    }
    propertyManager._set(analytics.Properties._EVENT_ID, 'PathChanged');

    VisualizationModule.sendManager(manager);
  },

  viewEventObjectDetail: function(objectName, segmentBy) {
    var clonedManager = analytics.PropertyManager._getInstance()._clonePersistent();

    clonedManager._set(analytics.Properties._DRILLDOWN, objectName);
    clonedManager._set(analytics.Properties._SEGMENT_BY, segmentBy);
    clonedManager._set(analytics.Properties._EVENT_ID, '');

    gaNavigator.changeLocation('event_object_detail?' +
        clonedManager._getQueryString());
  },

  viewEventObjectActionDetail: function(objectName, drilldownValue, detailType) {
    var clonedManager = analytics.PropertyManager._getInstance()._clonePersistent();

    clonedManager._set(analytics.Properties._DRILLDOWN, objectName);
    clonedManager._set(analytics.Properties._DRILLDOWN2, drilldownValue);
    clonedManager._set(analytics.Properties._EVENT_ID, '');

    var report;
    if (detailType == 'event_action') {
      report = 'event_object_action_detail';
    } else {
      report = 'event_object_label_detail';
    }

    gaNavigator.changeLocation(report + '?' + clonedManager._getQueryString());
  },

  changeSingleItemReport: function(newReport) {
    var pages = new Object();
    pages['ADS_REVENUE'] = 'adsense_trending_revenue';
    pages['ADS_REVENUE_PER_THOUSAND_VISITS'] =
        'adsense_revenue_per_thousand_visits';
    pages['ADS_CLICKED'] = 'adsense_trending_clicks';
    pages['ADS_CLICKED_PER_VISIT'] = 'adsense_clicks_per_visit';
    pages['ADS_CLICK_THROUGH_RATE'] = 'adsense_trending_ctr';
    pages['ADS_ESTIMATED_COST_PER_MILLE'] = 'adsense_trending_ecpm';
    pages['ADS_UNITS_VIEWED'] = 'adsense_trending_unit_impressions';
    pages['ADS_UNITS_VIEWED_PER_VISIT'] =
        'adsense_trending_unit_impressions_per_visit';
    pages['ADS_PAGES_VIEWED'] = 'adsense_trending_page_impressions';
    pages['ADS_PAGES_VIEWED_PER_VISIT'] = 'adsense_page_impressions_per_visit';

    pages['VISITS_WITH_SEARCHES'] = 'search_visits';
    pages['UNIQUE_INTERNAL_SEARCHES'] = 'unique_searches';
    pages['PAGEVIEWS_PER_SEARCH'] = 'search_pageviews';
    pages['PERCENT_SEARCH_EXITS'] = 'search_exits';
    pages['PERCENT_SEARCH_REFINEMENTS'] = 'search_refinements';
    pages['DURATION_PER_SEARCH'] = 'search_duration';
    pages['DEPTH_PER_SEARCH'] = 'search_depth';

    pages['EVENTS'] = 'events_item';
    pages['VISITS_WITH_EVENT'] = 'visits_with_event';
    pages['EVENTS_PER_VISIT'] = 'events_per_visit';
    VisualizationModule.changeReport(pages[newReport]);
  },

  showTrendalyzer: function() {
    var newPropertyManager = analytics.PropertyManager._getNewInstance();
    newPropertyManager._addProperties(
        analytics.PropertyManager._getInstance()._getQueryString());
    newPropertyManager.clear(analytics.Properties._EVENT_ID);
    newPropertyManager.clear(analytics.Properties._TABLE_VIEW);

    gaNavigator.changeLocation('trend?' +
        newPropertyManager._getQueryString());
  }

};

var FormsetSections = function(id, default_section) {
  this.id = id;
  this.currentSection = default_section;
};
FormsetSections.prototype = {
  toggle: function(section) {
    if (this.currentSection == section) return;

    goog.style.setStyle(document.getElementById(this.id + '_section_' + this.currentSection), 'display', 'none');

    goog.style.setStyle(document.getElementById(this.id + '_section_' + section), 'display', 'block');

    goog.dom.classes.remove(document.getElementById(this.id + '_tab_' + this.currentSection), 'current');

    goog.dom.classes.add(document.getElementById(this.id + '_tab_' + section), 'current');

    this.currentSection = section;

    email_preview.update(section);
  }
}

var EmailPreview = function(numScheduledEmails, numReports) {
  this.numScheduledEmails = numScheduledEmails;
  this.numReports = numReports;
  this.numFormats = 4;
};
EmailPreview.prototype = {
  update: function(source) {
    this.updateToEmails(source);
    this.updateSubject(source);
    this.updateDescription(source);
    this.updateAttachments(source);
  },
  setNumReports: function(numReports) {
    this.numReports = numReports;
  },
  updateToEmails: function(source) {
    var to_emails = '';
    var user_email = userEmail;
    if (source != 'add_to') {
      var recipientsElement =
          document.getElementById('f_email_' + source + '_to_emails');
      if (recipientsElement) {
        to_emails = recipientsElement.value;
      }
      to_emails = to_emails.replace(/,/g, ', ');
      var ccSelfElement = document.getElementById('f_email_' + source + '_cc_self');
      if (ccSelfElement && ccSelfElement.checked) {
        if (to_emails != '') {
          to_emails += ', ' + user_email;
        } else {
          to_emails = user_email;
        }
      }
    } else {
      for (var s = 0; s < this.numScheduledEmails; s++) {
        var targetElement =
            document.getElementById('f_email_target_schedule_' + s);
        if (targetElement && targetElement.checked) {
          to_emails = document.getElementById('f_email_target_schedule_' + s + '_to_emails').innerHTML;
        }
      }
    }
    document.getElementById('f_email_preview_to_emails').innerHTML =
      scriptEscape(to_emails);
  },
  updateSubject: function(source) {
    var subject = '';

    var schedule = 'now';
    if (source == 'schedule') {
      var scheduleElement = document.getElementById('f_email_schedule_repeating_schedule');
      if (scheduleElement) {
        var selectedSchedule = scheduleElement.options[scheduleElement.selectedIndex];
        schedule = selectedSchedule.value;
      }
    }
    var date_range = subjectDate[schedule];
    if (source != 'add_to') {
      subject = date_range;
      var subjectElement = document.getElementById('f_email_' + source + '_subject');
      var userText = '';
      if (subjectElement) {
        userText = subjectElement.value;
      }
      if (userText.length > 0) {
        subject += ' (' + userText + ')';
      }
    } else {
      for (var s = 0; s < this.numScheduledEmails; s++) {
        var targetElement =
            document.getElementById('f_email_target_schedule_' + s);
        if (targetElement && targetElement.checked) {
          subject = document.getElementById('f_email_target_schedule_' + s + '_subject').innerHTML;
        }
        date_range = '';
      }
    }
    document.getElementById('f_email_preview_subject').innerHTML =
      scriptEscape(subject);
  },
  updateDescription: function(source) {
    var description = '';
    if (source != 'add_to') {
      var bodyElement = document.getElementById('f_email_' + source + '_description');
      if (bodyElement) {
        description = bodyElement.value;
      }
    } else {
      for (var i = 0; i < this.numScheduledEmails; i++) {
        var targetElement =
            document.getElementById('f_email_target_schedule_' + i);
        if (targetElement && targetElement.checked) {
          var dataFieldId = 'f_email_target_schedule_' + i + '_description';
          var dataField = document.getElementById(dataFieldId);
          description = dataField.innerHTML;
        }
      }
    }
    document.getElementById('f_email_preview_description').innerHTML =
      scriptEscape(description);
  },
  updateAttachments: function(source) {
    var formatName = '';
    var attachmentText = '';

    if (source == 'send_now' || source == 'schedule' || source == 'edit') {
      for (var f = 0; f < this.numFormats; f++) {
        var formatRadioId = 'f_email_' + source + '_format_' + (f + 1);
        var currentFormatRadio = document.getElementById(formatRadioId);
        if (currentFormatRadio && currentFormatRadio.checked) {
          formatName = currentFormatRadio.value;
          break;
        }
      }

      if (source == 'send_now') {
        var formatNum = 0;
        if (formatName == 'pdf') {
          formatNum = 0;
        } else if (formatName == 'xml') {
          formatNum = 1;
        } else if (formatName == 'csv') {
          formatNum = 2;
        } else if (formatName == 'tsv') {
          formatNum = 3;
        } else if (formatName == 'csv_excel') {
          formatNum = 4;
        }

        var href = 'export' +
                   '?' + analytics.Properties._EXPORT_FORMAT +
                        '=' + formatNum +
                   '&' + analytics.Properties._REPORT_NAME +
                        '=' + enc_report_name +
                   '&' + analytics.PropertyManager._getInstance().
                            _getQueryString();

        attachmentText =
          '<a href="' + href + '" class="' + formatName + '">' + formatName.toUpperCase() + '</a>';
      } else {
        attachmentText = '<div class="' + formatName + '">' +
                         formatName.toUpperCase() + '</div>';
      }
    } else if (source == 'add_to') {
      for (var i = 0; i < this.numScheduledEmails; i++) {
        var targetElement =
            document.getElementById('f_email_target_schedule_' + i);
        if (targetElement && targetElement.checked) {
          var dataFieldId = 'f_email_target_schedule_' + i + '_format';
          var dataField = document.getElementById(dataFieldId);
          formatName = dataField.innerHTML;
        }
      }
      attachmentText = '<div class="' + formatName + '">' +
                       formatName + '</div>';
    }
    document.getElementById('f_email_preview_attachments').innerHTML = attachmentText;
  }
}

function scriptEscape(str) {
  str = str.replace(/\>/g, '&gt;');
  str = str.replace(/\</g, '&lt;');
  return str;
}

function _openHelp(path) {
  var manager = analytics.PropertyManager._getInstance();
  var lang = manager._get(analytics.Properties._LOCALE_HELP);
  var urlPath = 'http://www.google.com/support/googleanalytics/bin/';
  var url = '';

  if (window.helpCenterUrlPath && window.helpCenterUrlPath != '') {
    urlPath = window.helpCenterUrlPath;
  }

  // Temporary work around.
  var newPath = path.replace(/ /g, '');
  newPath = newPath.replace(/75968/, '76269');

  if (path.indexOf('?') > -1) {
    url = urlPath + newPath + '&hl=' + lang;
  } else {
    url = urlPath + newPath + '?hl=' + lang;
  }
  var mywin = window.open(url, 'gahelp', 'scrollbars=yes,menubar=yes,toolbar=yes,location=yes,width=800,height=600,resizable=yes');
  mywin.focus();
}

function getLimitParam() {
  var regexp = new RegExp('[\\?&]limit=([^&#]*)');
  var results = regexp.exec(window.location.href);
  var limit = (results == null) ? null : results[1];
  return (limit && limit != '') ? ('&limit=' + limit) : '';
}
