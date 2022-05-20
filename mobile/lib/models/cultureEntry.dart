import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';

class cultureEntry {
  final String imagePath, title, description, location;
  final List categoryIds, galleryImages;

  cultureEntry(
      {this.imagePath,
      this.title,
      this.description,
      this.location,
      this.categoryIds,
      this.galleryImages});
}

final aux1 = cultureEntry(
    imagePath: "lib/views/cultural/auxPics/1.jpg",
    title: "AUX1",
    description: "AUX1",
    location: "AUX1",
    categoryIds: [0, 1]);

final aux2 = cultureEntry(
    imagePath: "lib/views/cultural/auxPics/1.jpg",
    title: "aux2",
    description: "aux2",
    location: "aux2",
    categoryIds: [0, 2]);

final aux3 = cultureEntry(
    imagePath: "lib/views/cultural/auxPics/1.jpg",
    title: "aux3",
    description: "aux3",
    location: "aux3",
    categoryIds: [0, 3]);

final aux4 = cultureEntry(
    imagePath: "lib/views/cultural/auxPics/1.jpg",
    title: "aux4",
    description: "aux4",
    location: "aux4",
    categoryIds: [0, 4]);

final aux5 = cultureEntry(
    imagePath: "lib/views/cultural/auxPics/1.jpg",
    title: "aux5",
    description: "aux5",
    location: "aux5",
    categoryIds: [0, 5]);
