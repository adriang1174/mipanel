// Customizable variables
var DefaultDateFormat = 'DD/MM/YYYY'; // If no date format is supplied, this will be used instead
var HideWait = 3; // Number of seconds before the calendar will disappear
var Y2kPivotPoint = 76; // 2-digit years before this point will be created in the 21st century
var UnselectedMonthText = ''; // Text to display in the 1st month list item when the date isn't required
var FontSize = 11; // In pixels
var FontFamily = 'Tahoma';
var CellWidth = 18;
var CellHeight = 16;
var ImageURL = '<!--{ipath name="calendar.jpg"}-->';
var NextURL = '<!--{ipath name="next.gif"}-->';
var PrevURL = '<!--{ipath name="prev.gif"}-->';
var CalBGColor = 'white';
var TopRowBGColor = 'buttonface';
var DayBGColor = 'lightgrey';

// Global variables
var ZCounter = 100;
var Today = new Date();
var WeekDays = new Array('<!--{lang k=SUNDAY_FIRST_LETTER}-->','<!--{lang k=MONDAY_FIRST_LETTER}-->','<!--{lang k=TUESDAY_FIRST_LETTER}-->','<!--{lang k=WEDNESDAY_FIRST_LETTER}-->','<!--{lang k=THURSDAY_FIRST_LETTER}-->','<!--{lang k=FRIDAY_FIRST_LETTER}-->','<!--{lang k=SATURDAY_FIRST_LETTER}-->');
var MonthDays = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
var MonthNames = new Array('<!--{lang k=JANUARY}-->','<!--{lang k=FEBRUARY}-->','<!--{lang k=MARCH}-->','<!--{lang k=APRIL}-->','<!--{lang k=MAY}-->','<!--{lang k=JUNE}-->','<!--{lang k=JULY}-->','<!--{lang k=AUGOUST}-->','<!--{lang k=SEPTEMBER}-->','<!--{lang k=OCTOBER}-->','<!--{lang k=NOVEMBER}-->','<!--{lang k=DECEMBER}-->');