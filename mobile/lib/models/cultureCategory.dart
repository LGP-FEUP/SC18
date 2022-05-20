import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';

class cultureCategory {
  final int categoryId;
  final String name;
  final IconData icon;

  cultureCategory({this.categoryId, this.name, this.icon});
}

final allCat = cultureCategory(
  categoryId: 0,
  name: "All",
  icon: Icons.circle
);

final foodCat = cultureCategory(
  categoryId: 1,
  name: "Food",
  icon: Icons.restaurant,
);

final artCat = cultureCategory(
  categoryId: 2,
  name: "Art",
  icon: Icons.palette,
);

final sportsCat =
    cultureCategory(categoryId: 3, name: "Sports", icon: Icons.sports);

final religionCat =
    cultureCategory(categoryId: 4, name: "Religion", icon: Icons.church);

final architectureCat = cultureCategory(
  categoryId: 5,
  name: "Architecture",
  icon: Icons.architecture,
);

final cultureCategories = [
  allCat,
  foodCat,
  sportsCat,
  religionCat,
  architectureCat
]
