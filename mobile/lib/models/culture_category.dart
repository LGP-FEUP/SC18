import 'package:flutter/material.dart';

class CultureCategory {
  final String categoryId;
  final String title;
  final IconData icon;

  CultureCategory(this.categoryId, this.title, this.icon);

  CultureCategory.fromJson(this.categoryId, Map<String, dynamic> json)
      : title = json['title'],
        icon = Icons.add;

  Map<String, dynamic> toJson() => {
        'title': title,
      };
}

// final allCat = CultureCategory(0, "All", Icons.circle);
//
// final foodCat = CultureCategory(
//   1,
//   "Food",
//   Icons.restaurant,
// );
//
// final artCat = CultureCategory(
//   2,
//   "Art",
//   Icons.palette,
// );
//
// final sportsCat = CultureCategory(3, "Sports", Icons.sports);
//
// final religionCat = CultureCategory(4, "Explore", Icons.nordic_walking);
//
// final studyCat = CultureCategory(
//   5,
//   "study",
//   Icons.book,
// );

// final cultureCategories = [
//   allCat,
//   foodCat,
//   artCat,
//   sportsCat,
//   religionCat,
//   studyCat
// ];
