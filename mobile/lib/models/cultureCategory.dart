import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';

class CultureCategory {
  final int categoryId;
  final String name;
  final IconData icon;

  CultureCategory(this.categoryId, this.name, this.icon);
}

final allCat = CultureCategory(0, "All", Icons.circle);

final foodCat = CultureCategory(
  1,
  "Food",
  Icons.restaurant,
);

final artCat = CultureCategory(
  2,
  "Art",
  Icons.palette,
);

final sportsCat = CultureCategory(3, "Sports", Icons.sports);

final religionCat = CultureCategory(4, "Religion", Icons.church);

final architectureCat = CultureCategory(
  5,
  "Architecture",
  Icons.architecture,
);

final cultureCategories = [
  allCat,
  foodCat,
  sportsCat,
  religionCat,
  architectureCat
];
