import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';

class ForumCategory {
  final int categoryId;
  final String name;
  final IconData icon;

  ForumCategory(this.categoryId, this.name, this.icon);
}

final allCat = ForumCategory(0, "All", Icons.circle);

final foodCat = ForumCategory(
  1,
  "Food",
  Icons.restaurant,
);

final artCat = ForumCategory(
  2,
  "Art",
  Icons.palette,
);

final sportsCat = ForumCategory(3, "Sports", Icons.sports);

final religionCat = ForumCategory(4, "Religion", Icons.church);

final architectureCat = ForumCategory(
  5,
  "Architecture",
  Icons.architecture,
);

final forumCategories = [
  allCat,
  foodCat,
  sportsCat,
  religionCat,
  architectureCat
];
